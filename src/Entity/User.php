<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="usuario")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500, unique=true )
     */
    private $KeycloakId;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToOne(targetEntity=PersonaFisica::class, mappedBy="usuario", cascade={"persist", "remove"})
     */
    private $personasFisicas;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKeycloakId(): ?int
    {
        return $this->KeycloakId;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setKeycloakId(string $KeycloakId): self
    {
        $this->KeycloakId = $KeycloakId;

        return $this;
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
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPersonasFisicas(): ?PersonaFisica
    {
        return $this->personasFisicas;
    }

    public function setPersonasFisicas(?PersonaFisica $personasFisicas): self
    {
        // unset the owning side of the relation if necessary
        if ($personasFisicas === null && $this->personasFisicas !== null) {
            $this->personasFisicas->setUsuario(null);
        }

        // set the owning side of the relation if necessary
        if ($personasFisicas !== null && $personasFisicas->getUsuario() !== $this) {
            $personasFisicas->setUsuario($this);
        }

        $this->personasFisicas = $personasFisicas;

        return $this;
    }
}
