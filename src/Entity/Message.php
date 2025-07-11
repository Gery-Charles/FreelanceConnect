<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $emetteur = null;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\ManyToMany(targetEntity: Utilisateur::class)]
    private Collection $receveur;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEnvoi = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    private ?Conversation $conversation = null;

    public function __construct()
    {
        $this->receveur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getEmetteur(): ?Utilisateur
    {
        return $this->emetteur;
    }

    public function setEmetteur(?Utilisateur $emetteur): static
    {
        $this->emetteur = $emetteur;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getReceveur(): Collection
    {
        return $this->receveur;
    }

    public function addReceveur(Utilisateur $receveur): static
    {
        if (!$this->receveur->contains($receveur)) {
            $this->receveur->add($receveur);
        }

        return $this;
    }

    public function removeReceveur(Utilisateur $receveur): static
    {
        $this->receveur->removeElement($receveur);

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(\DateTimeInterface $dateEnvoi): static
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    public function getConversation(): ?Conversation
    {
        return $this->conversation;
    }

    public function setConversation(?Conversation $conversation): static
    {
        $this->conversation = $conversation;

        return $this;
    }
}
