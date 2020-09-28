<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Product
 * @package App\Entity
 *
 * @ApiResource(
 *     iri="http://schema.org/Product",
 *     normalizationContext={"groups"={"product:read"}},
 *     denormalizationContext={"groups"={"product:write"}},
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
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Table(name="bm_products", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_name", columns={"name"})})
 * @UniqueEntity(fields={"name"}, message="Un produit existe déjà avec ce nom.")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"product:read", "user:read"})
     *
     * @ApiProperty(iri="http://schema.org/productID")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Groups({"product:read", "product:write", "user:read"})
     *
     * @ApiProperty(iri="http://schema.org/name")
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups({"product:read", "product:write", "user:read"})
     *
     * @ApiProperty(iri="http://schema.org/description")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Groups({"product:read", "product:write", "user:read"})
     *
     * @ApiProperty(iri="http://schema.org/brand")
     */
    private $brand;

    /**
     * @ORM\Column(type="integer", options={"default":0})
     *
     * @Groups({"product:read", "product:write", "user:read"})
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, options={"default":0})
     *
     * @Groups({"product:read", "product:write", "user:read"})
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups({"product:read", "user:read"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups({"product:read", "user:read"})
     */
    private $updated_at;

    /**
     * @var array
     * @Groups({"product:read", "user:read"})
     */
    private $_links = [];

    /**
     * Product constructor.
     * @throws \Exception
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
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     *
     * @return $this
     */
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param string|null $brand
     *
     * @return $this
     */
    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return $this
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return $this
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

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
            'self' => '/api/products/'.$this->id,
            'update' => '/api/products/'.$this->id,
            'delete' => '/api/products/'.$this->id
        ];
    }
}
