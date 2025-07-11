<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MissionRepository::class)]
#[Vich\Uploadable]
class Mission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['mission:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['mission:read'])]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['mission:read'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['mission:read'])]
    private ?string $duree = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['mission:read'])]
    private ?Client $client = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['mission:read'])]
    private ?\DateTimeInterface $datePublication = null;

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName')]
    #[Groups(['mission:read'])]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['mission:read'])]
    private ?string $imageName = null;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['mission:read'])]
    private bool $isImageUploaded = false;

    #[ORM\Column]
    #[Groups(['mission:read'])]
    private ?int $nombreCandidatures = null;

    /**
     * @var Collection<int, Freelance>
     */
    #[ORM\ManyToMany(targetEntity: Freelance::class, inversedBy: 'missions')]
    #[Groups(['mission:read'])]
    private Collection $candidatures;

    #[Groups(['mission:read'])]
    #[ORM\Column(length: 255)]
    private ?string $categorie = null;

    public function __construct()
    {
        $this->candidatures = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;
        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->datePublication = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getIsImageUploaded(): bool
    {
        return $this->isImageUploaded;
    }

    public function setIsImageUploaded(bool $isImageUploaded): void
    {
        $this->isImageUploaded = $isImageUploaded;
    }

    public function getNombreCandidatures(): ?int
    {
        return $this->nombreCandidatures;
    }

    public function setNombreCandidatures(int $nombreCandidatures): static
    {
        $this->nombreCandidatures = $nombreCandidatures;

        return $this;
    }

    /**
     * @return Collection<int, Freelance>
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Freelance $candidature): static
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures->add($candidature);
        }

        return $this;
    }

    public function removeCandidature(Freelance $candidature): static
    {
        $this->candidatures->removeElement($candidature);

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
