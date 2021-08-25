<?php

namespace App\Entity;

use App\Entity\ExemplaireJeu;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\JeuRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=JeuRepository::class)
 */
class Jeu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="integer")
     */
    private $joueurMin;

    /**
     * @ORM\Column(type="integer")
     */
    private $joueurMax;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $decription;

    /**
     * @ORM\Column(type="integer")
     */
    private $ageMin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ageMax;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contenu;


    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="jeux")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=ExemplaireJeu::class, mappedBy="jeu")
     */
    private $exemplaireJeux;

    public function __construct()
    {
        $this->exemplaireJeux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getJoueurMin(): ?int
    {
        return $this->joueurMin;
    }

    public function setJoueurMin(int $joueurMin): self
    {
        $this->joueurMin = $joueurMin;

        return $this;
    }

    public function getJoueurMax(): ?int
    {
        return $this->joueurMax;
    }

    public function setJoueurMax(int $joueurMax): self
    {
        $this->joueurMax = $joueurMax;

        return $this;
    }

    public function getDecription(): ?string
    {
        return $this->decription;
    }

    public function setDecription(?string $decription): self
    {
        $this->decription = $decription;

        return $this;
    }

    public function getAgeMin(): ?int
    {
        return $this->ageMin;
    }

    public function setAgeMin(int $ageMin): self
    {
        $this->ageMin = $ageMin;

        return $this;
    }

    public function getAgeMax(): ?int
    {
        return $this->ageMax;
    }

    public function setAgeMax(?int $ageMax): self
    {
        $this->ageMax = $ageMax;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }


    public function getCategorie(): Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|ExemplaireJeu[]
     */
    public function getExemplaireJeux(): Collection
    {
        return $this->exemplaireJeux;
    }

    public function addExemplaireJeux(ExemplaireJeu $exemplaireJeux): self
    {
        if (!$this->exemplaireJeux->contains($exemplaireJeux)) {
            $this->exemplaireJeux[] = $exemplaireJeux;
            $exemplaireJeux->setJeu($this);
        }

        return $this;
    }

    public function removeExemplaireJeux(ExemplaireJeu $exemplaireJeux): self
    {
        if ($this->exemplaireJeux->removeElement($exemplaireJeux)) {
            // set the owning side to null (unless already changed)
            if ($exemplaireJeux->getJeu() === $this) {
                $exemplaireJeux->setJeu(null);
            }
        }

        return $this;
    }
}
