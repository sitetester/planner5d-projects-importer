<?php

declare(strict_types=1);

namespace App\Service\Project\Parser;

use App\Entity\Project;
use App\Service\Project\ProjectDenormalizer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Psr\Log\LoggerInterface;
use Symfony\Component\DomCrawler\Crawler;

class ProjectDetailsParser
{
    private string $baseUrl;
    private Client $client;
    private LoggerInterface $logger;
    private ProjectDenormalizer $projectDenormalizer;

    public function __construct(
        string $baseUrl,
        Client $client,
        LoggerInterface $logger,
        ProjectDenormalizer $projectDenormalizer
    ) {
        $this->baseUrl = $baseUrl;
        $this->client = $client;
        $this->logger = $logger;
        $this->projectDenormalizer = $projectDenormalizer;
    }

    public function parse(string $html): Project
    {
        $crawler = new Crawler($html);
        $key = $this->parseProjectKey($crawler);

        $project = $this->projectDenormalizer->denormalize(
            $this->downloadProjectData($key)
        );

        $project->setAboutContents(
            $crawler->filterXPath('//html/body/main/div/div/div[1]/p')->text()
        );

        // similarly we can parse more info e.g. project comments, author, images
        return $project;
    }

    private function parseProjectKey(Crawler $crawler): string
    {
        $key = $crawler->filterXPath('//a[contains(@class, "button is-fullwidth is-primary")]/@href')->text();
        preg_match('#key=(.+)&#', $key, $matches);

        return $matches[1];
    }

    private function downloadProjectData(string $key): array
    {
        $url = $this->baseUrl . '/api/project/' . $key;
        $response = '';

        try {
            $response = $this->client->get($this->baseUrl . '/api/project/' . $key);
        } catch (GuzzleException $e) {
            $this->logger->debug("Couldn't load project data", ['url' => $url, 'exception' => $e->getMessage()]);
        }

        $json = $response->getBody()->getContents();

        $projectData = [];
        try {
            $projectData = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $this->logger->debug("Couldn't parse JSON for URL" . $url);
        }

        return $projectData;
    }
}
