<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Twig\Extension\StringLoaderExtension;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"email"}, message="quelqu'un possede deja cet email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * * @Assert\Email(
     *     message = "LE mmail '{{ value }}' n'est pas un mail valide.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="le password est obligatoire et doit etre au bon format")
     * @Assert\Length(min=8, minMessage="le mot de passe doit contenir au moins 8 caracteres")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string")
     *@Assert\Length(min = 10, max = 16, minMessage = "Au moins 10 nombres", maxMessage = "Maximum 16 carctères")
     *@Assert\Regex(pattern="/^((\+33)?\(0\))?[0-9]+$/", message="number_only") 
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @ORM\OrderBy({"inscription_at" = "desc"})
     */
    private $inscription_at;



    /**
     * @ORM\PrePersist
     *
     */
    public function inscription_date()
    {
        if (empty($this->inscription_at)) {
            $this->inscription_at = new \DateTime();
        }

    }


    /**
     * @ORM\PreUpdate
     *
     */


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
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    

    public function getFullName(): ?string 
    {
        return $this->firstName .'  '.$this->lastName;
    }



    public function getInscriptionAt(): ?\DateTimeInterface
    {
        return $this->inscription_at;
    }

    public function setInscriptionAt(?\DateTimeInterface $inscription_at): self
    {
        $this->inscription_at = $inscription_at;

        return $this;
    }

}
