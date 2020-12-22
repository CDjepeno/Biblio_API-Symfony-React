<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @ApiResource(
 *      attributes={
 *          "order"={
 *              "title":"ASC",
 *              "price":"DESC"
 *          }
 *       },
 *       collectionOperations={
 *           "get"={
 *              "method" = "GET",
 *              "path" = "/books",
 *              "normalization_context" = {
 *                  "groups" = {"get_role_member"},
 *               }
 *           },
 *           "post"={
 *              "method" = "POST",
 *              "security"="is_granted('ROLE_MANAGER')",
 *              "securiy_message"="Vous n'avez pas les droits d'acceder à cette ressource"
 *           }
 *      },
 *      itemOperation={
 *          "get"={
 *              "method" = "GET",
 *              "path" = "/book/{id}",
 *              "normalizationContext" = {
 *                  "groups" = {"get_role_member"}
 *               }
 *           },
 *            "put"={
 *              "method" = "PUT",
 *              "path" = "/book/{id}",
 *              "security"="is_granted('ROLE_MANAGER')",
 *              "security_message"="Vous n'avez pas les droits d'acceder à cette ressource",
 *              "denormalizationContext" = {
 *                  "groups"={"putManager"}
 *               }
 *           },
 *            "delete_admin"={
 *              "method" = "DELETE",
 *              "path" = "/book/{id}",
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous n'avez pas les droits d'acceder à cette ressource"
 *           }
 *      }
 * )
 * @ApiFilter(SearchFilter::class, properties={"title": "ipartial", "author": "exact", "genre": "exact"})
 * @ApiFilter(OrderFilter::class, properties={"title","price","author.firstname"})
 * @ApiFilter(PropertyFilter::class, arguments={"parameterName":"properties","overrideDefaultProperties":"false","whitelist"={"isbn","title"}})
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_role_member","putManager"})
     */
    private $isbn;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_role_member","putManager"})
     * 
     */
    private $title;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"get_role_manager", "put_admin"})
     * 
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Genre::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $genre;

    /**
     * @ORM\ManyToOne(targetEntity=Editor::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get_role_member","putManager"})
     */
    private $editor;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get_role_member","putManager"})
     * 
     */
    private $author;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"get_role_member","putManager"})
     * 
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_role_member","putManager"})
     */
    private $langue;

    /**
     * @ORM\OneToMany(targetEntity=BookRent::class, mappedBy="book")
     * @Groups({"get_role_manager"})
     */
    private $bookRents;

    public function __construct()
    {
        $this->bookRents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getEditor(): ?Editor
    {
        return $this->editor;
    }

    public function setEditor(?Editor $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * @return Collection|BookRent[]
     */
    public function getBookRents(): Collection
    {
        return $this->bookRents;
    }

    public function addBookRent(BookRent $bookRent): self
    {
        if (!$this->bookRents->contains($bookRent)) {
            $this->bookRents[] = $bookRent;
            $bookRent->setBook($this);
        }

        return $this;
    }

    public function removeBookRent(BookRent $bookRent): self
    {
        if ($this->bookRents->removeElement($bookRent)) {
            // set the owning side to null (unless already changed)
            if ($bookRent->getBook() === $this) {
                $bookRent->setBook(null);
            }
        }

        return $this;
    }
}
