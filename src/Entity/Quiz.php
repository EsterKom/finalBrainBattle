<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $quiz_name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $quiz_description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'quizzes')]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'quizzes')]
    private ?Level $level = null;

    #[ORM\OneToMany(mappedBy: 'quiz', targetEntity: Favourite::class, orphanRemoval: true)]
    private Collection $favourites;

    #[ORM\OneToMany(mappedBy: 'quiz', targetEntity: UserQuiz::class)]
    private Collection $userQuizzes;

    public function __construct()
    {
        $this->favourites = new ArrayCollection();
        $this->userQuizzes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuizName(): ?string
    {
        return $this->quiz_name;
    }

    public function setQuizName(string $quiz_name): static
    {
        $this->quiz_name = $quiz_name;

        return $this;
    }

    public function getQuizDescription(): ?string
    {
        return $this->quiz_description;
    }

    public function setQuizDescription(?string $quiz_description): static
    {
        $this->quiz_description = $quiz_description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): static
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection<int, Favourite>
     */
    public function getFavourites(): Collection
    {
        return $this->favourites;
    }

    public function addFavourite(Favourite $favourite): static
    {
        if (!$this->favourites->contains($favourite)) {
            $this->favourites->add($favourite);
            $favourite->setQuiz($this);
        }

        return $this;
    }

    public function removeFavourite(Favourite $favourite): static
    {
        if ($this->favourites->removeElement($favourite)) {
            // set the owning side to null (unless already changed)
            if ($favourite->getQuiz() === $this) {
                $favourite->setQuiz(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserQuiz>
     */
    public function getUserQuizzes(): Collection
    {
        return $this->userQuizzes;
    }

    public function addUserQuiz(UserQuiz $userQuiz): static
    {
        if (!$this->userQuizzes->contains($userQuiz)) {
            $this->userQuizzes->add($userQuiz);
            $userQuiz->setQuiz($this);
        }

        return $this;
    }

    public function removeUserQuiz(UserQuiz $userQuiz): static
    {
        if ($this->userQuizzes->removeElement($userQuiz)) {
            // set the owning side to null (unless already changed)
            if ($userQuiz->getQuiz() === $this) {
                $userQuiz->setQuiz(null);
            }
        }

        return $this;
    }
}
