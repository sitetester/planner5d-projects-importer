<?php

declare(strict_types=1);

namespace App\Service\Project;

use App\Entity\Project;

class ProjectDenormalizer
{
    public function denormalize(array $projectData): Project
    {
        $project = new Project();

        $project
            ->setTitle($projectData['items'][0]['name'])
            ->setHash($projectData['items'][0]['hash']);

        $projectItems = $projectData['items'][0]['data']['items'];

        $project
            ->setNumFloors($this->parseNumFloors($projectItems))
            ->setNumRooms($this->parseNumRooms($projectItems))
            ->setNumOtherItems($this->parseNumOtherItems($projectItems));

        return $project;
    }

    private function parseNumFloors(array $projectItems): int
    {
        $count = 0;
        foreach ($projectItems as $item) {
            if ($item['className'] === 'Floor') {
                ++$count;
            }
        }

        return $count;
    }

    private function parseNumRooms(array $projectItems): int
    {
        $count = 0;
        foreach ($projectItems as $floor) {
            if (array_key_exists('items', $floor)) {
                foreach ($floor['items'] as $floorItem) {
                    if ($floorItem['className'] === 'Room') {
                        ++$count;
                    }
                }
            }
        }

        return $count;
    }

    private function parseNumOtherItems(array $items, int $count = 0): int
    {
        foreach ($items as $item) {
            // excluding `Floors` & `Rooms` items
            if ($item['className'] !== 'Floor' && $item['className'] !== 'Room') {
                ++$count;
            }

            if (array_key_exists('items', $item)) {
                $count = $this->parseNumOtherItems($item['items'], $count);
            }
        }

        return $count;
    }
}
