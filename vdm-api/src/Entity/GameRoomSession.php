<?php

namespace App\Entity;

use App\Repository\GameRoomSessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRoomSessionRepository::class)]
#[ORM\Table(name: 'game_room_session')]
class GameRoomSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name: 'id_game_room')]
    private GameRoom $room;

    #[ORM\Column(nullable: false)]
    private \DateTimeImmutable $startAt;

    #[ORM\Column(nullable: false)]
    private \DateTimeImmutable $endAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoom(): GameRoom
    {
        return $this->room;
    }

    public function setRoom(GameRoom $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getStartAt(): \DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): \DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }
}
