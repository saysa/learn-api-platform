<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\HomeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=HomeRepository::class)
 */
class Home
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"renter:read"})
     */
    private $title;

    /**
     * @ORM\Column(type="float")
     * @Groups({"renter:read"})
     */
    private $surface;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"renter:read"})
     */
    private $place;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"renter:read"})
     */
    private $price;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"renter:read"})
     */
    private $equipments = [];

    /**
     * @ORM\ManyToOne(targetEntity=Renter::class, inversedBy="home")
     */
    private $renter;

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

    public function getSurface(): ?float
    {
        return $this->surface;
    }

    public function setSurface(float $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

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

    public function getEquipments(): ?array
    {
        return $this->equipments;
    }

    public function setEquipments(?array $equipments): self
    {
        $this->equipments = $equipments;

        return $this;
    }

    public function getRenter(): ?Renter
    {
        return $this->renter;
    }

    public function setRenter(?Renter $renter): self
    {
        $this->renter = $renter;

        return $this;
    }
}
