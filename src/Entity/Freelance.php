<?php

namespace App\Entity;

use App\Repository\FreelanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FreelanceRepository::class)]
class Freelance extends Utilisateur
{
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $competances = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $candidatures = null;

    /**
     * @var Collection<int, Mission>
     */
    #[ORM\ManyToMany(targetEntity: Mission::class, mappedBy: 'candidatures')]
    private Collection $missions;

    public function __construct()
    {
        $this->missions = new ArrayCollection();
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCompetances(): array
    {
        return $this->competances;
    }

    public function setCompetances(array $competances): static
    {
        $this->competances = $competances;

        return $this;
    }

    public function getCandidatures(): ?array
    {
        return $this->candidatures;
    }

    public function setCandidatures(?array $candidatures): static
    {
        $this->candidatures = $candidatures;

        return $this;
    }

    /**
     * @return Collection<int, Mission>
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): static
    {
        if (!$this->missions->contains($mission)) {
            $this->missions->add($mission);
            $mission->addCandidature($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): static
    {
        if ($this->missions->removeElement($mission)) {
            $mission->removeCandidature($this);
        }

        return $this;
    }
}
