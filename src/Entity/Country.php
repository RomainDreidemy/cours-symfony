<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=Beer::class, mappedBy="country")
     */
    private $beer;

    public function __construct()
    {
        $this->beer = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Beer[]
     */
    public function getBeer(): Collection
    {
        return $this->beer;
    }

    public function addBeer(Beer $beer): self
    {
        if (!$this->beer->contains($beer)) {
            $this->beer[] = $beer;
            $beer->setCountry($this);
        }

        return $this;
    }

    public function removeBeer(Beer $beer): self
    {
        if ($this->beer->removeElement($beer)) {
            // set the owning side to null (unless already changed)
            if ($beer->getCountry() === $this) {
                $beer->setCountry(null);
            }
        }

        return $this;
    }
}
