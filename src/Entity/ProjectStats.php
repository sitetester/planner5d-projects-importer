<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProjectStatsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectStatsRepository::class)
 * @ORM\Table(name="project_stats")
 */
class ProjectStats
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $numViews = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private int $numLikes = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private int $numComments = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumViews(): int
    {
        return $this->numViews;
    }

    public function setNumViews(int $numViews): ProjectStats
    {
        $this->numViews = $numViews;

        return $this;
    }

    public function getNumLikes(): int
    {
        return $this->numLikes;
    }

    public function setNumLikes(int $numLikes): ProjectStats
    {
        $this->numLikes = $numLikes;

        return $this;
    }

    public function getNumComments(): int
    {
        return $this->numComments;
    }

    public function setNumComments(int $numComments): ProjectStats
    {
        $this->numComments = $numComments;

        return $this;
    }
}
