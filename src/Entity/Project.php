<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 * @ORM\Table(name="projects")
 *
 * https://symfony.com/doc/current/reference/constraints/UniqueEntity.html#basic-usage
 * @UniqueEntity("hash")
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $link;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $hash;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @OneToOne(targetEntity="App\Entity\ProjectThumbnail", cascade={"persist", "remove"})
     * @JoinColumn(name="thumbnail_id", referencedColumnName="id")
     */
    private ProjectThumbnail $thumbnail;

    /**
     * @OneToOne(targetEntity="App\Entity\ProjectStats", cascade={"persist", "remove"})
     * @JoinColumn(name="stats_id", referencedColumnName="id")
     */
    private ProjectStats $stats;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $aboutContents;

    /**
     * @ORM\Column(type="integer")
     */
    private int $numFloors;

    /**
     * @ORM\Column(type="integer")
     */
    private int $numRooms;

    /**
     * @ORM\Column(type="integer")
     */
    private int $numOtherItems;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $hits = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): Project
    {
        $this->link = $link;

        return $this;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash(string $hash): Project
    {
        $this->hash = $hash;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Project
    {
        $this->title = $title;

        return $this;
    }

    public function getThumbnail(): ProjectThumbnail
    {
        return $this->thumbnail;
    }

    public function setThumbnail(ProjectThumbnail $thumbnail): Project
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getStats(): ProjectStats
    {
        return $this->stats;
    }

    public function setStats(ProjectStats $stats): Project
    {
        $this->stats = $stats;

        return $this;
    }


    public function getAboutContents(): string
    {
        return $this->aboutContents;
    }

    public function setAboutContents(string $aboutContents): Project
    {
        $this->aboutContents = $aboutContents;

        return $this;
    }

    public function getNumFloors(): int
    {
        return $this->numFloors;
    }

    public function setNumFloors(int $numFloors): Project
    {
        $this->numFloors = $numFloors;

        return $this;
    }

    public function getNumRooms(): int
    {
        return $this->numRooms;
    }

    public function setNumRooms(int $numRooms): Project
    {
        $this->numRooms = $numRooms;

        return $this;
    }

    public function getNumOtherItems(): int
    {
        return $this->numOtherItems;
    }

    public function setNumOtherItems(int $numOtherItems): Project
    {
        $this->numOtherItems = $numOtherItems;

        return $this;
    }

    public function getHits(): ?int
    {
        return $this->hits;
    }

    public function setHits(int $hits): Project
    {
        $this->hits = $hits;

        return $this;
    }
}
