<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RenterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"renter:read"}},
 *     denormalizationContext={"groups"={"renter:write"}},
 *     itemOperations={
 *          "get",
 *          "put"={
 *              "normalization_context"={"groups"={"renter:read", "renter:update"}},
 *              "denormalization_context"={"groups"={"renter:update"}}
 *          },
 *          "delete"
 *     }
 * )
 * @ORM\Entity(repositoryClass=RenterRepository::class)
 */
class Renter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"renter:read", "renter:write", "renter:update"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"renter:write", "renter:update", "role:admin", "renter:editable"})
     */
    private $firstname;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }
}
