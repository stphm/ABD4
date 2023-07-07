<?php

namespace App\Entity;

use App\Repository\GameRoomRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRoomRepository::class)]
#[ORM\Table(name: 'game_room')]
class GameRoom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ReferenceGameRoomTheme $theme;

    #[ORM\Column(nullable: false)]
    private int $duration = 60;

    #[ORM\Column]
    private bool $isVr = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheme(): ReferenceGameRoomTheme
    {
        return $this->theme;
    }

    public function setTheme(ReferenceGameRoomTheme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function isIsVr(): bool
    {
        return $this->isVr;
    }

    public function setIsVr(bool $isVr): self
    {
        $this->isVr = $isVr;

        return $this;
    }
}
