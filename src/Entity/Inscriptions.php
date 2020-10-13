<?php

namespace App\Entity;

use App\Repository\InscriptionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionsRepository::class)
 */
class Inscriptions
{

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInscription;

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity=Sorties::class, inversedBy="noSortie")
     */
    private $sortiesNoSortie;

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $participantsNoParticipant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getSortiesNoSortie(): ?int
    {
        return $this->sortiesNoSortie;
    }

    public function setSortiesNoSortie(int $sortiesNoSortie): self
    {
        $this->sortiesNoSortie = $sortiesNoSortie;

        return $this;
    }

    public function getParticipantsNoParticipant(): ?int
    {
        return $this->participantsNoParticipant;
    }

    public function setParticipantsNoParticipant(int $participantsNoParticipant): self
    {
        $this->participantsNoParticipant = $participantsNoParticipant;

        return $this;
    }
}
