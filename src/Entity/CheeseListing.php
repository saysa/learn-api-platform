<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Repository\CheeseListingRepository;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={
 *         "get",
 *         "put",
 *         "patch"
 *     },
 *     normalizationContext={"groups"={"cheesing_listing:read"}},
 *     denormalizationContext={"groups"={"cheesing_listing:write"}},
 *     shortName="cheeses",
 *     attributes={
 *         "pagination_items_per_page"=1,
 *         "formats"={"jsonld", "json", "html", "jsonhal", "csv"={"text/csv"}}
 *     }
 * )
 * @ORM\Entity(repositoryClass=CheeseListingRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"isPublished"})
 * @ApiFilter(SearchFilter::class, properties={"title": "partial", "description": "partial"})
 * @ApiFilter(RangeFilter::class, properties={"price"})
 * @ApiFilter(PropertyFilter::class)
 */
class CheeseListing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cheesing_listing:read", "cheesing_listing:write"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"cheesing_listing:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"cheesing_listing:read", "cheesing_listing:write"})
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished = false;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cheeseListings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"cheesing_listing:read", "cheesing_listing:write"})
     */
    private $owner;

    public function __construct(string $title = null)
    {
        $this->createAt = new \DateTimeImmutable();
        $this->title = $title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @Groups({"cheesing_listing:read"})
     *
     * @return string|null
     */
    public function getShortDescription(): ?string
    {
        if (strlen($this->description) < 40) {
            return $this->description;
        }

        return substr($this->description, 0, 40).'...';
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * With documentation.
     *
     * @Groups({"cheesing_listing:write"})
     * @SerializedName("description")
     *
     * @return $this
     */
    public function setTextDescription(string $description): self
    {
        $this->description = nl2br($description);

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    /**
     * How much time ago?
     *
     * @Groups({"cheesing_listing:read"})
     */
    public function getCreateAtAgo(): string
    {
        return Carbon::instance($this->getCreateAt())->diffForHumans();
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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
