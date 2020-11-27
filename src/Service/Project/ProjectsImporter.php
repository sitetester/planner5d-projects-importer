<?php

declare(strict_types=1);

namespace App\Service\Project;

use App\Service\Project\Parser\ProjectsParser;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;

class ProjectsImporter
{
    private string $baseUrl;
    private Client $client;
    private LoggerInterface $logger;
    private ProjectsParser $projectsParser;
    private EntityManagerInterface $entityManager;

    public function __construct(
        string $baseUrl,
        Client $client,
        LoggerInterface $logger,
        ProjectsParser $projectsParser,
        EntityManagerInterface $entityManager
    ) {
        $this->baseUrl = $baseUrl;
        $this->client = $client;
        $this->logger = $logger;
        $this->projectsParser = $projectsParser;
        $this->entityManager = $entityManager;
    }

    public function import($page = 1, int $maxPages = 5): bool
    {
        $this->logger->debug('Importing page: ' . $page);
        $url = $this->baseUrl . '/gallery/floorplans?page=' . $page;

        $response = '';
        try {
            $response = $this->client->get($url);
        } catch (GuzzleException $e) {
            $this->logger->debug($e->getMessage());
        }

        $html = $response->getBody()->getContents();
        $this->persistProjects($this->projectsParser->parseHtml($html));

        ++$page;
        if ($page <= $maxPages) {
            $this->import($page, $maxPages);
        }

        return true;
    }

    /**
     * https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/reference/batch-processing.html#bulk-inserts
     * @param array $projects
     */
    private function persistProjects(array $projects): void
    {
        foreach ($projects as $project) {
            $this->entityManager->persist($project);
        }

        $this->entityManager->flush();
    }
}
