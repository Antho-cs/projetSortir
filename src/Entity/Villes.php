<?php

namespace App\Entity;

use App\Repository\VillesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VillesRepository::class)
 */
class Villes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $noVille;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nomVille;

    /**
     * @ORM\Column(type="integer")
     */
    private $codePostal;


    public function getNoVille(): ?int
    {
        return $this->noVille;
    }

    public function getNomVille(): ?string
    {
        return $this->nomVille;
    }

    public function setNomVille(string $nomVille): self
    {
        $this->nomVille = $nomVille;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setNoVille(int $noVille): self
    {
        $this->noVille = $noVille;

        return $this;
    }
}
