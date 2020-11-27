<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProjectThumbnailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectThumbnailRepository::class)
 * @ORM\Table(name="project_thumbnail")
 */
class ProjectThumbnail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $src;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $alt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSrc(): string
    {
        return $this->src;
    }

    public function setSrc(string $src): ProjectThumbnail
    {
        $this->src = $src;

        return $this;
    }

    public function getAlt(): string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): ProjectThumbnail
    {
        $this->alt = $alt;

        return $this;
    }
}
