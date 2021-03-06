<?php

declare(strict_types=1);

namespace App\Entity;

use App\Doctrine\UuidType;
use Symfony\Component\Uid\Uuid;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"producer"="App\Entity\Producer", "customer"="App\Entity\Customer"})
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
abstract class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(type="uuid", unique=true)
     */
    protected Uuid $uuid;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    protected ?string $firstName = null;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    protected ?string $lastName = null;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected ?string $email = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $password = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $plainPassword = null;

    /**
     * @ORM\Column(type="datetime_immutable", options={"default":"CURRENT_TIMESTAMP"})
     */
    protected DateTimeImmutable $registeredAt;

    /**
     * @ORM\Embedded(class="ForgottenPassword")
     */
    protected ?ForgottenPassword $forgottenPassword;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
        $this->registeredAt = new DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->forgottenPassword = null;
        $this->password = $password;
    }

    public function getRegisteredAt(): ?\DateTimeImmutable
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt($registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function hasForgotHisPassword(): void
    {
        $this->forgottenPassword = new ForgottenPassword();
    }
    public function getFullName(): string
    {
        return sprintf("%s %s", $this->firstName, $this->lastName);
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function setUuid(Uuid $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getForgottenPassword()
    {
        return $this->forgottenPassword;
    }
}
