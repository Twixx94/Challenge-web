<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\LabelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\SerializerInterface;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: LabelRepository::class)]
#[ApiResource()]
#[ApiFilter(SearchFilter::class, properties: ['type' => 'exact'])]
class Label
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'label', targetEntity: Note::class, orphanRemoval: true)]
    #[Groups(['read:label:Collection'])]
    private Collection $notes;
    

    public function __construct(SerializerInterface $serializer)
    {
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setLabel($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getLabel() === $this) {
                $note->setLabel(null);
            }
        }

        return $this;
    }
}
