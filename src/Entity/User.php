<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Favourite::class, orphanRemoval: true)]
    private Collection $favourites;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserQuiz::class)]
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

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
            $favourite->setUser($this);
        }

        return $this;
    }

    public function removeFavourite(Favourite $favourite): static
    {
        if ($this->favourites->removeElement($favourite)) {
            // set the owning side to null (unless already changed)
            if ($favourite->getUser() === $this) {
                $favourite->setUser(null);
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
            $userQuiz->setUser($this);
        }

        return $this;
    }

    public function removeUserQuiz(UserQuiz $userQuiz): static
    {
        if ($this->userQuizzes->removeElement($userQuiz)) {
            // set the owning side to null (unless already changed)
            if ($userQuiz->getUser() === $this) {
                $userQuiz->setUser(null);
            }
        }

        return $this;
    }
}
