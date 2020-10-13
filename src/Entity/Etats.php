<?php

namespace App\Entity;

use App\Repository\EtatsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatsRepository::class)
 */
class Etats
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $noEtat;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $libelle;


    public function getNoEtat(): ?int
    {
        return $this->noEtat;
    }

    public function setNoEtat(int $noEtat): self
    {
        $this->noEtat = $noEtat;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }
}
