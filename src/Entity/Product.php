<?php

namespace App\Entity;

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
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
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
     * @Groups("read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Groups({"read", "write"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups({"read", "write"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Groups({"read", "write"})
     */
    private $brand;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups("read")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups("read")
     */
    private $updated_at;

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
}
