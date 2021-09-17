<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\ExistsFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\ResetHomeController;
use App\Filter\NotNameFilter;
use App\Repository\RenterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"renter:list"}},
 *     denormalizationContext={"groups"={"renter:write"}},
 *     itemOperations={
 *          "reset_home"={
 *              "method"="DELETE",
 *              "path"="/renters/{id}/reset_home",
 *              "controller"=ResetHomeController::class
 *          },
 *          "get"={
 *              "normalization_context"={"groups"={"renter:read"}}
 *          },
 *          "put"={
 *              "normalization_context"={"groups"={"renter:read"}},
 *              "denormalization_context"={"groups"={"renter:update"}}
 *          },
 *          "delete"
 *     }
 * )
 * @ApiFilter(ExistsFilter::class, properties={"home"})
 * @ApiFilter(SearchFilter::class, properties={"home.place":"partial"})
 * @ApiFilter(NotNameFilter::class, properties={"not_name"})
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
     * @Groups({"renter:list", "renter:write", "renter:update"})
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"renter:list", "renter:read", "renter:admin", "renter:editable"})
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @ORM\OneToMany(targetEntity=Home::class, mappedBy="renter", cascade={"persist", "remove"})
     * @Groups({"renter:list", "renter:read"})
     * @Assert\Valid()
     */
    private $home;

    public function __construct()
    {
        $this->home = new ArrayCollection();
    }

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

    /**
     * @return Collection|Home[]
     */
    public function getHome(): Collection
    {
        return $this->home;
    }

    public function addHome(Home $home): self
    {
        if (!$this->home->contains($home)) {
            $this->home[] = $home;
            $home->setRenter($this);
        }

        return $this;
    }

    public function removeHome(Home $home): self
    {
        if ($this->home->removeElement($home)) {
            // set the owning side to null (unless already changed)
            if ($home->getRenter() === $this) {
                $home->setRenter(null);
            }
        }

        return $this;
    }

    /**
     * @Groups({"renter:list"})
     */
    public function getTotalHomes()
    {
        return count($this->home);
    }
}
