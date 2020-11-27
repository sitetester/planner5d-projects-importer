<?php

declare(strict_types=1);

namespace App\Entity;

// This entity is only used at App level, not meant to persist
class ProjectInfo
{
    private string $link;
    private ProjectThumbnail $thumbnail;
    private ProjectStats $projectStat;

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): ProjectInfo
    {
        $this->link = $link;

        return $this;
    }

    public function getThumbnail(): ProjectThumbnail
    {
        return $this->thumbnail;
    }

    public function setThumbnail(ProjectThumbnail $thumbnail): ProjectInfo
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getProjectStat(): ProjectStats
    {
        return $this->projectStat;
    }

    public function setProjectStat(ProjectStats $projectStat): ProjectInfo
    {
        $this->projectStat = $projectStat;

        return $this;
    }
}
