<?php

namespace App\Entity;

use App\Entity\LoolyMedia\Media;
use App\Repository\Portfolio\PortfolioMediasRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortfolioMediasRepository::class)]
class PortfolioMedias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'portfolioMedias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Portfolio $portfolio = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Media $media = null;

    #[ORM\ManyToOne]
    private ?PortfolioCategoryMedia $category = null;

    #[ORM\Column]
    private ?int $sort = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPortfolio(): ?Portfolio
    {
        return $this->portfolio;
    }

    public function setPortfolio(?Portfolio $portfolio): static
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): static
    {
        $this->media = $media;

        return $this;
    }

    public function getCategory(): ?PortfolioCategoryMedia
    {
        return $this->category;
    }

    public function setCategory(?PortfolioCategoryMedia $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): static
    {
        $this->sort = $sort;

        return $this;
    }
}
