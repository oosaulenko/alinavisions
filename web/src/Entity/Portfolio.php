<?php

namespace App\Entity;

use App\Entity\LoolyMedia\Media;
use App\Repository\Portfolio\PortfolioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortfolioRepository::class)]
class Portfolio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $title = null;

    #[ORM\Column(length: 200)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $short_description = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\ManyToOne(inversedBy: 'portfolios')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(length: 120, nullable: true)]
    private ?string $client = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 20)]
    private ?string $access = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $locale = null;

    #[ORM\Column(nullable: true)]
    private ?array $data = null;

    #[ORM\Column(nullable: true)]
    private ?array $relative_locales = null;

    /**
     * @var Collection<int, Media>
     */
    #[ORM\ManyToMany(targetEntity: Media::class)]
    private Collection $media;

    #[ORM\ManyToOne]
    private ?Media $image = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $hash = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $hast_at = null;

    #[ORM\ManyToOne]
    private ?Photoshoot $photoshoot = null;

    /**
     * @var Collection<int, PortfolioCategoryMedia>
     */
    #[ORM\OneToMany(targetEntity: PortfolioCategoryMedia::class, mappedBy: 'portfolio', orphanRemoval: true)]
    private Collection $portfolioCategoryMedia;

    /**
     * @var Collection<int, PortfolioMedias>
     */
    #[ORM\OneToMany(targetEntity: PortfolioMedias::class, mappedBy: 'portfolio', orphanRemoval: true)]
    private Collection $portfolioMedias;

    public function __construct()
    {
        $this->media = new ArrayCollection();
        $this->portfolioCategoryMedia = new ArrayCollection();
        $this->portfolioMedias = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getExcerpt(): ?string
    {
        return substr($this->short_description, 0, 100) . '...';
    }


    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(?string $short_description): static
    {
        $this->short_description = $short_description;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(?\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(?string $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAccess(): ?string
    {
        return $this->access;
    }

    public function setAccess(string $access): static
    {
        $this->access = $access;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function setCreatedAtDefault(): static
    {
        $this->created_at = new \DateTimeImmutable();

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function setUpdatedAtDefault(): static
    {
        $this->updated_at = new \DateTimeImmutable();

        return $this;
    }

    public function _actions(): array
    {
        return [
            'clone' => null,
            'view' => 'app_portfolio_single',
            'download_link' => 'app_portfolio_single'
        ];
    }

    public function _getSection(): string
    {
        return 'portfolio';
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getRelativeLocales(): ?array
    {
        return $this->relative_locales;
    }

    public function setRelativeLocales(?array $relative_locales): static
    {
        $this->relative_locales = $relative_locales;

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): static
    {
        if (!$this->media->contains($medium)) {
            $this->media->add($medium);
        }

        return $this;
    }

    public function removeMedium(Media $medium): static
    {
        $this->media->removeElement($medium);

        return $this;
    }

    public function getImage(): ?Media
    {
        return $this->image;
    }

    public function setImage(?Media $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(): static
    {
        if(!$this->hash) {
            $this->hash = substr(uniqid(), 0, 10);
        }

        return $this;
    }

    public function getHastAt(): ?\DateTimeImmutable
    {
        return $this->hast_at;
    }

    public function setHastAt(?\DateTimeImmutable $hast_at): static
    {
        $this->hast_at = $hast_at;

        return $this;
    }

    public function getPhotoshoot(): ?Photoshoot
    {
        return $this->photoshoot;
    }

    public function setPhotoshoot(?Photoshoot $photoshoot): static
    {
        $this->photoshoot = $photoshoot;

        return $this;
    }

    /**
     * @return Collection<int, PortfolioCategoryMedia>
     */
    public function getPortfolioCategoryMedia(): Collection
    {
        return $this->portfolioCategoryMedia;
    }

    public function getCategoriesMedia(): array
    {
        $categoriesMedia = [];
        foreach ($this->getPortfolioCategoryMedia() as $categoryMedia) {
            $categoriesMedia[$categoryMedia->getName()] = $categoryMedia;
        }
        ksort($categoriesMedia);

        return $categoriesMedia;
    }

    public function getPortfolioCM(): array
    {
        $portfolioCM = [];
        foreach ($this->getPortfolioCategoryMedia() as $PortfolioCategoryMedia) {
            $portfolioCM[$PortfolioCategoryMedia->getSort()] = $PortfolioCategoryMedia;
        }
        ksort($portfolioCM);

        return $portfolioCM;
    }

    public function addPortfolioCategoryMedium(PortfolioCategoryMedia $portfolioCategoryMedium): static
    {
        if (!$this->portfolioCategoryMedia->contains($portfolioCategoryMedium)) {
            $this->portfolioCategoryMedia->add($portfolioCategoryMedium);
            $portfolioCategoryMedium->setPortfolio($this);
        }

        return $this;
    }

    public function removePortfolioCategoryMedium(PortfolioCategoryMedia $portfolioCategoryMedium): static
    {
        if ($this->portfolioCategoryMedia->removeElement($portfolioCategoryMedium)) {
            // set the owning side to null (unless already changed)
            if ($portfolioCategoryMedium->getPortfolio() === $this) {
                $portfolioCategoryMedium->setPortfolio(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PortfolioMedias>
     */
    public function getPortfolioMedias(): Collection
    {
        return $this->portfolioMedias;
    }

    public function getMedias(): array
    {
        $medias = [];

        foreach ($this->getPortfolioMedias() as $media) {
            $categoryName = $media->getCategory() ? $media->getCategory()->getName() : 'none';
            $medias[$categoryName][$media->getMedia()->getId()] = $media;
        }

        return $medias;
    }

    public function getPortfolioM(): array
    {
        $items = $this->getPortfolioMedias()->toArray();

        // 1) Сортуємо за sort
        usort($items, static fn($a, $b) => $a->getSort() <=> $b->getSort());

        $count = count($items);
        if ($count === 0 || 3 <= 1) {
            return $items;
        }

        $rows = (int) ceil($count / 3);

        // 3) Трансформуємо у порядок "по колонках": 1,4,2,5,3,6
        $result = [];
        for ($col = 0; $col < 3; $col++) {
            for ($row = 0; $row < $rows; $row++) {
                $idx = $row * 3 + $col; // КЛЮЧОВИЙ момент
                if ($idx < $count) {
                    $result[] = $items[$idx];
                }
            }
        }

        return $result;
    }

    public function addPortfolioMedia(PortfolioMedias $portfolioMedia): static
    {
        if (!$this->portfolioMedias->contains($portfolioMedia)) {
            $this->portfolioMedias->add($portfolioMedia);
            $portfolioMedia->setPortfolio($this);
        }

        return $this;
    }

    public function removePortfolioMedia(PortfolioMedias $portfolioMedia): static
    {
        if ($this->portfolioMedias->removeElement($portfolioMedia)) {
            // set the owning side to null (unless already changed)
            if ($portfolioMedia->getPortfolio() === $this) {
                $portfolioMedia->setPortfolio(null);
            }
        }

        return $this;
    }
}
