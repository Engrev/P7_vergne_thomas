<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * Class User
 * @package App\Entity
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}}
 * )
 *
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="bm_users", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_email", columns={"email"})})
 * @UniqueEntity(fields={"email"}, message="Un utilisateur existe déjà avec cet email.")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"user:read", "product:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"user:read", "user:write", "product:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *
     * @Groups({"user:read", "user:write", "product:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     *
     * @Groups({"user:read", "user:write"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @SerializedName("password")
     *
     * @Groups("user:write")
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="user", orphanRemoval=true)
     *
     * @ApiSubresource()
     *
     * @Groups("user:read")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity=Customer::class, mappedBy="user", orphanRemoval=true)
     *
     * @ApiSubresource()
     *
     * @Groups("user:read")
     */
    private $customers;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups("user:read")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups("user:read")
     */
    private $updated_at;

    /**
     * @var array
     * @Groups({"user:read", "product:read"})
     */
    private $links = [];

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->created_at = $this->updated_at = new \DateTime("now", new \DateTimeZone("Europe/Paris"));
        $this->products = new ArrayCollection();
        $this->customers = new ArrayCollection();
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

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
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    /**
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles = ['ROLE_USER']): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param string $roles
     *
     * @return bool
     */
    public function hasRoles(string $roles): bool
    {
        return in_array($roles, $this->roles);
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     *
     * @return $this
     */
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param Product $product
     *
     * @return $this
     */
    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setUser($this);
        }

        return $this;
    }

    /**
     * @param Product $product
     *
     * @return $this
     */
    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getUser() === $this) {
                $product->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    /**
     * @param Customer $customer
     *
     * @return $this
     */
    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->setUser($this);
        }

        return $this;
    }

    /**
     * @param Customer $customer
     *
     * @return $this
     */
    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->contains($customer)) {
            $this->customers->removeElement($customer);
            // set the owning side to null (unless already changed)
            if ($customer->getUser() === $this) {
                $customer->setUser(null);
            }
        }

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
            'self' => $_ENV['APP_DOMAIN_NAME_ENTITIES_LINKS'].'/users/'.$this->id,
            'update' => $_ENV['APP_DOMAIN_NAME_ENTITIES_LINKS'].'/users/'.$this->id,
            'delete' => $_ENV['APP_DOMAIN_NAME_ENTITIES_LINKS'].'/users/'.$this->id
        ];
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
        $this->plainPassword = null;
    }
}
