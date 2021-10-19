<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\BooksRepository;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ApiResource(
 *     collectionOperations={"get","post"},
 *     itemOperations={"get","put","delete"},
 *     normalizationContext={
 *          "groups"={"books:read"}
 *     },
 *     denormalizationContext={
 *          "groups"={"books:write"}
 *     }
 * )
 * @ORM\Entity(repositoryClass=BooksRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"isPublished"})
 * @ApiFilter(SearchFilter::class, properties={"title": "partial"})
 */
class Books
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Tutaj podajemy tytuł książki
     * @ORM\Column(type="string", length=255)
     * @Groups({"books:read","books:write"})
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"books:read","books:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"books:read","books:write"})
     */
    private $version;

    /**
     * @ORM\Column(type="date")
     */
    private $releaseDate;

    /**
     * @ORM\Column(type="float")
     * @Groups({"books:read", "books:write"})
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished = false;

    public function __construct()
    {
        $this->releaseDate = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     * @Groups({"books:write"})
     */
    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    /**
     * @return string
     * @Groups({"books:read"})
     */
    public function getReleaseDateAgo(): string
    {
        Carbon::setLocale("pl");
        return Carbon::instance($this->getReleaseDate())->diffForHumans();
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }
}
