<?php

namespace App\Entity;

use App\Repository\ParticipantsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=ParticipantsRepository::class)
 * @UniqueEntity(fields={"Pseudo"}, message="There is already an account with this Pseudo")
 */
class Participants implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="SVP renseignez votre pseudo!")
     * @Assert\Length(
     *     min="3",
     *     max="8",
     *     minMessage="trop court",
     *     maxMessage="trop long"
     * )
     * @ORM\Column(type="string", length=30, unique=true)
     */
    private $Pseudo;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     *@Assert\NotBlank(message="SVP renseignez le mot de passe!")
     *@Assert\Regex("/(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?=.*[A-Z])(?=.*[a-z]).*$/g")
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password; //TODO Regex mdp

    /**
     *@Assert\NotBlank(message="SVP renseignez le nom!")
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @Assert\NotBlank(message="SVP renseignez le prénom!")
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telephone;

    /**
     *@Assert\NotBlank(message="SVP renseignez le mail!")
     * @ORM\Column(type="string", length=150)
     */
    private $mail;

    /**
     * @ORM\Column(type="boolean")
     */
    private $administrateur;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="participants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campus;

    /**
     * @ORM\OneToMany(targetEntity=Inscriptions::class, mappedBy="participant")
     */
    private $inscriptions;

    /**
     * @ORM\OneToMany(targetEntity=Sorties::class, mappedBy="organisateur")
     */
    private $sortiesCreated;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $urlPhoto;


    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->sortiesCreated = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->Pseudo;
    }

    public function setPseudo(string $Pseudo): self
    {
        $this->Pseudo = $Pseudo;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->Pseudo;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getAdministrateur(): ?bool
    {
        return $this->administrateur;
    }

    public function setAdministrateur(bool $administrateur): self
    {
        $this->administrateur = $administrateur;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
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
            $inscription->setParticipant($this);
        }

        return $this;
    }

    public function removeInscription(Inscriptions $inscription): self
    {
        if ($this->inscriptions->contains($inscription)) {
            $this->inscriptions->removeElement($inscription);
            // set the owning side to null (unless already changed)
            if ($inscription->getParticipant() === $this) {
                $inscription->setParticipant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sorties[]
     */
    public function getSortiesCreated(): Collection
    {
        return $this->sortiesCreated;
    }

    public function addSortiesCreated(Sorties $sortiesCreated): self
    {
        if (!$this->sortiesCreated->contains($sortiesCreated)) {
            $this->sortiesCreated[] = $sortiesCreated;
            $sortiesCreated->setOrganisateur($this);
        }

        return $this;
    }

    public function removeSortiesCreated(Sorties $sortiesCreated): self
    {
        if ($this->sortiesCreated->contains($sortiesCreated)) {
            $this->sortiesCreated->removeElement($sortiesCreated);
            // set the owning side to null (unless already changed)
            if ($sortiesCreated->getOrganisateur() === $this) {
                $sortiesCreated->setOrganisateur(null);
            }
        }

        return $this;
    }

    public function getUrlPhoto(): ?string
    {
        return $this->urlPhoto;
    }

    public function setUrlPhoto(?string $urlPhoto): self
    {
        $this->urlPhoto = $urlPhoto;

        return $this;
    }
}
