<?php

namespace App\Entity;

use App\Repository\UserQuizRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserQuizRepository::class)]
class UserQuiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $score = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $time_taken = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_played = null;

    #[ORM\ManyToOne(inversedBy: 'userQuizzes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userQuizzes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getTimeTaken(): ?\DateTimeInterface
    {
        return $this->time_taken;
    }

    public function setTimeTaken(?\DateTimeInterface $time_taken): static
    {
        $this->time_taken = $time_taken;

        return $this;
    }

    public function getDatePlayed(): ?\DateTimeInterface
    {
        return $this->date_played;
    }

    public function setDatePlayed(?\DateTimeInterface $date_played): static
    {
        $this->date_played = $date_played;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): static
    {
        $this->quiz = $quiz;

        return $this;
    }
}
