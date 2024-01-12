<?php

namespace App\Entity;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
#[ApiResource()]
#[ApiFilter(SearchFilter::class, properties: ['label' => 'exact'])]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'notes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:note'])] // Un groupe différent de celui utilisé pour 'Label'
    private ?Label $label = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getLabel(): ?Label
    {
        return $this->label;
    }

    public function setLabel(?Label $label): static
    {
        $this->label = $label;

        return $this;
    }
}
