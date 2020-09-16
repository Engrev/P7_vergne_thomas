<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Customer
 * @package App\Entity
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"customer:read"}},
 *     denormalizationContext={"groups"={"customer:write"}},
 *     collectionOperations={
 *         "get",
 *         "post"={"security"="is_granted('ROLE_USER')"}
 *     },
 *     itemOperations={
 *         "get",
 *         "put"={"security"="is_granted('edit', object)"},
 *         "delete"={"security"="is_granted('delete', object)"}
 *     }
 * )
 *
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * @ORM\Table(name="bm_customers", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_email", columns={"email"})})
 * @UniqueEntity(fields={"email"}, message="Un client existe déjà avec cet email.")
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"customer:read", "user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Groups({"customer:read", "customer:write", "user:read"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Groups({"customer:read", "customer:write", "user:read"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"customer:read", "customer:write", "user:read"})
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="customers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups({"customer:read", "user:read"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups({"customer:read", "user:read"})
     */
    private $updated_at;

    /**
     * @var array
     * @Groups({"customer:read", "user:read"})
     */
    private $links = [];

    /**
     * Customer constructor.
     */
    public function __construct()
    {
        $this->created_at = $this->updated_at = new \DateTime("now", new \DateTimeZone("Europe/Paris"));
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     *
     * @return $this
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     *
     * @return $this
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     *
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @param \DateTimeInterface $created_at
     *
     * @return $this
     */
    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    /**
     * @return $this
     */
    public function setUpdatedAt(): self
    {
        $this->updated_at = new \DateTime("now", new \DateTimeZone("Europe/Paris"));

        return $this;
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return [
            'self' => $_ENV['APP_DOMAIN_NAME_ENTITIES_LINKS'].'/customers/'.$this->id,
            'update' => $_ENV['APP_DOMAIN_NAME_ENTITIES_LINKS'].'/customers/'.$this->id,
            'delete' => $_ENV['APP_DOMAIN_NAME_ENTITIES_LINKS'].'/customers/'.$this->id
        ];
    }
}
