<?php

declare(strict_types=1);

namespace App\Tests\Service\Project;

use App\Service\Project\ProjectDenormalizer;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectDenormalizerTest extends WebTestCase
{
    /**
     * How to verify ?
     *
     * Searching for className": " (ignoring "className": null) shows total 69 occurrences
     * one occurrences is for "className": "Project"
     * one occurrences is for "className": "Floor"
     * one occurrences is for "className": "Room"
     * while remaining 2 under "stored" for lines 1537 & 2527
     * so 69 - 5 = 64 are target occurrences
     * @throws JsonException
     */
    public function testDenormalize(): void
    {
        $client = self::createClient();
        $container = $client->getContainer();

        $filePath = '/tests/resources/projects/abd27171208e447dee77cd593585e91d.json';
        $path = $container->get('kernel')->getProjectDir() . $filePath;
        $json = file_get_contents($path);

        $projectData = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        $projectDetails = (new ProjectDenormalizer())->denormalize($projectData);

        self::assertEquals(64, $projectDetails->getNumOtherItems());
    }
}
