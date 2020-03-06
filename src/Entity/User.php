<?php

namespace App\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="flash_user")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="This value {{ value }} is already used"
 * )
 * @UniqueEntity(
 *     fields={"confirmationCode"},
 *     message="This value {{ value }} is already used"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Serializer\Groups({"user_details", "user_list", "user_embed"})
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @Serializer\Groups({"user_details", "user_list", "user_embed"})
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @Serializer\Groups({"user_details", "user_list", "user_embed"})
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Serializer\Groups({"user_details", "user_list", "user_embed"})
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $active;

    /**
     * @Serializer\Groups({"user_details", "user_list", "user_embed"})
     * @ORM\OneToMany(targetEntity="App\Entity\Deck", mappedBy="user", orphanRemoval=true)
     */
    private $decks;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $confirmationCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;


    public function __construct()
    {
        $this->setActive(false);
        $this->decks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getActive()
    {
      return $this->active;
    }

    public function setActive($active): self
    {
      $this->active = $active;

      return $this;
    }

    /**
     * @see UserInterface
     */
    public function getConfirmationCode()
    {
      return $this->confirmationCode;
    }

    public function setConfirmationCode($confirmationCode): self
    {
      $this->confirmationCode = $confirmationCode;

      return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
        return $this->getEmail();
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Deck[]
     */
    public function getDecks(): Collection
    {
        return $this->decks;
    }

    public function addDeck(Deck $deck): self
    {
        if (!$this->decks->contains($deck)) {
            $this->decks[] = $deck;
            $deck->setUser($this);
        }

        return $this;
    }

    public function removeDeck(Deck $deck): self
    {
        if ($this->decks->contains($deck)) {
            $this->decks->removeElement($deck);
            // set the owning side to null (unless already changed)
            if ($deck->getUser() === $this) {
                $deck->setUser(null);
            }
        }

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }


}
