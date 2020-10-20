<?php

namespace App\Entity;

use App\Repository\SortiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SortiesRepository::class)
 */
class Sorties
{
    public const CREATE = 'Créée';
    public const OPEN = 'Ouverte';
    public const FENCE = 'Clôturée';
    public const ONGOING = 'Activité en cours';
    public const PAST = 'Passée';
    public const CANCEL = 'Annulée';


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCloture;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbInscriptionsmax;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $descriptionsInfos;

    /**
     * @ORM\OneToMany(targetEntity=Inscriptions::class, mappedBy="sortie")
     */
    private $inscriptions;

    /**
     * @ORM\ManyToOne(targetEntity=Etats::class, inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Etats $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Lieux::class, inversedBy="sorties", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $lieu;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campus;

    /**
     * @ORM\ManyToOne(targetEntity=Participants::class, inversedBy="sortiesCreated")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organisateur;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $motifAnnulation;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }


    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateCloture(): ?\DateTimeInterface
    {
        return $this->dateCloture;
    }

    public function setDateCloture(\DateTimeInterface $dateCloture): self
    {
        $this->dateCloture = $dateCloture;

        return $this;
    }

    public function getNbInscriptionsmax(): ?int
    {
        return $this->nbInscriptionsmax;
    }

    public function setNbInscriptionsmax(int $nbInscriptionsmax): self
    {
        $this->nbInscriptionsmax = $nbInscriptionsmax;

        return $this;
    }

    public function getDescriptionsInfos(): ?string
    {
        return $this->descriptionsInfos;
    }

    public function setDescriptionsInfos(?string $descriptionsInfos): self
    {
        $this->descriptionsInfos = $descriptionsInfos;

        return $this;
    }

    /**
     * @return Collection|Inscriptions[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscriptions $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setSortie($this);
        }

        return $this;
    }

    public function removeInscription(Inscriptions $inscription): self
    {
        if ($this->inscriptions->contains($inscription)) {
            $this->inscriptions->removeElement($inscription);
            // set the owning side to null (unless already changed)
            if ($inscription->getSortie() === $this) {
                $inscription->setSortie(null);
            }
        }

        return $this;
    }

    public function getEtat(): ?Etats
    {
        return $this->etat;
    }

    public function setEtat(?Etats $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getLieu(): ?Lieux
    {
        return $this->lieu;
    }

    public function setLieu(?Lieux $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    public function getOrganisateur(): ?Participants
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Participants $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }


    public function getMotifAnnulation(): ?string
    {
        return $this->motifAnnulation;
    }

    public function setMotifAnnulation(?string $motifAnnulation): self
    {
        $this->motifAnnulation = $motifAnnulation;

        return $this;
    }

        public
        function canPublish(Participants $participant): bool
        {
            return $this->organisateur === $participant && self::OPEN == $this->etat->getLibelle();
        }

        public
        function canModify(Participants $participant): bool
        {
            return $this->organisateur === $participant && self::CREATE == $this->etat->getLibelle();
        }

        public
        function canRead(): bool
        {
            return self::PAST === $this->etat->getLibelle() || self::ONGOING === $this->etat->getLibelle() || self::OPEN === $this->etat->getLibelle();
        }

        public
        function canCancel(Participants $participant): bool
        {
            return $this->organisateur === $participant && self::OPEN == $this->etat->getLibelle();

        }

    }

