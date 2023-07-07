<?php

namespace App\Entity;

use App\Repository\ReferencePeopleCivilityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReferencePeopleCivilityRepository::class)]
class ReferencePeopleCivility
{
    public const CIVILITY_MISTER = 'M.';
    public const CIVILITY_MADAM = 'Mme';
    public const CIVILITY_OTHER = 'Autre';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $label = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
