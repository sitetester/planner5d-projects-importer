<?php

declare(strict_types=1);

namespace App\Service\Project\Parser;

use App\Entity\Project;
use App\Entity\ProjectInfo;
use App\Entity\ProjectStats;
use App\Entity\ProjectThumbnail;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Symfony\Component\DomCrawler\Crawler;

class ProjectsParser
{
    private string $baseUrl;
    private Client $client;
    private LoggerInterface $logger;
    private ProjectDetailsParser $projectDetailsParser;

    public function __construct(
        string $baseUrl,
        Client $client,
        ProjectDetailsParser $projectDetailsParser
    ) {
        $this->baseUrl = $baseUrl;
        $this->client = $client;
        $this->projectDetailsParser = $projectDetailsParser;
    }

    /**
     * @param string $html
     * @return Project[]
     */
    public function parseHtml(string $html): array
    {
        $projectsInfo = $this->parseProjectsInfo(new Crawler($html));

        $projects = [];
        foreach ($projectsInfo as $projectInfo) {
            $url = $this->baseUrl . $projectInfo->getLink();

            $response = '';
            try {
                $response = $this->client->get($url);
            } catch (GuzzleException $exception) {
                $this->logger->debug("Couldn't load URl: $url");
            }

            $projectDetailsHtml = $response->getBody()->getContents();
            $project = $this->projectDetailsParser->parse($projectDetailsHtml);

            $project
                ->setLink($projectInfo->getLink())
                ->setThumbnail($projectInfo->getThumbnail())
                ->setStats($projectInfo->getProjectStat());

            $projects[] = $project;
        }

        return $projects;
    }

    /**
     * @param Crawler $crawler
     * @return ProjectInfo[]
     */
    private function parseProjectsInfo(Crawler $crawler): array
    {
        return $crawler->filterXPath('//div[contains(@class, "card ideas-card")]')->each(
            function (Crawler $div) {
                $stats = $div->filterXPath('//div[contains(@class, "card-info")]')->text();
                // convert string values into int
                $intStats = array_map(static fn($stat) => (int)$stat, explode(" ", $stats));

                return (new ProjectInfo())
                    ->setLink($div->filterXPath('//a/@href')->text())
                    ->setThumbnail(
                        (new ProjectThumbnail())
                            ->setSrc($div->filterXPath("//a/img/@src")->text())
                            ->setAlt($div->filterXPath("//a/img/@alt")->text())
                    )
                    ->setProjectStat(
                        (new ProjectStats())
                            ->setNumViews($intStats[0])
                            ->setNumLikes($intStats[1])
                            ->setNumComments($intStats[2] ?? 0)
                    );
            }
        );
    }
}
