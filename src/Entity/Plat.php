<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlatRepository")
 */
class Plat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(min=3, max=50, minMessage="Le Nom est trop court ! Il doit plus de 3 lettres du con !")
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=500)
     * @Assert\Length(min=4, max=500)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url()
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="plat", orphanRemoval=true)
     */
    private $resa;

    public function __construct()
    {
        $this->resa = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getResa(): Collection
    {
        return $this->resa;
    }

    public function addResa(Reservation $resa): self
    {
        if (!$this->resa->contains($resa)) {
            $this->resa[] = $resa;
            $resa->setPlat($this);
        }

        return $this;
    }

    public function removeResa(Reservation $resa): self
    {
        if ($this->resa->contains($resa)) {
            $this->resa->removeElement($resa);
            // set the owning side to null (unless already changed)
            if ($resa->getPlat() === $this) {
                $resa->setPlat(null);
            }
        }

        return $this;
    }
}
