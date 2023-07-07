<?php

namespace App\Entity;

use App\Repository\ReferenceGameRoomThemeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReferenceGameRoomThemeRepository::class)]
#[ORM\Table(name: 'reference_game_room_theme')]
class ReferenceGameRoomTheme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $label;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
