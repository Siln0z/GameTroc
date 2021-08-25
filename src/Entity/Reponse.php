<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReponseRepository::class)
 */
class Reponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateReponse;

    /**
     * @ORM\Column(type="text")
     */
    private $texte;

    /**
     * @ORM\Column(type="boolean")
     */
    private $moderationReponse;

    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class, inversedBy="reponses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $annonce;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reponses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    public function __construct()
    {
        $this->dateReponse = new \DateTime();
        $this->moderationReponse = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReponse(): ?\DateTimeInterface
    {
        return $this->dateReponse;
    }

    public function setDateReponse(?\DateTimeInterface $dateReponse): self
    {
        $this->dateReponse = $dateReponse;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getModerationReponse(): ?bool
    {
        return $this->moderationReponse;
    }

    public function setModerationReponse(bool $moderationReponse): self
    {
        $this->moderationReponse = $moderationReponse;

        return $this;
    }

    public function getAnnonce(): Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
