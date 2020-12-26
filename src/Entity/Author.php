<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AuthorRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=AuthorRepository::class)
 * @ApiResource(
 *      attributes={
 *          "order"={"firstname":"ASC"},
 *          "pagination_enabled"=false
 *      },
 *      collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path" = "/authors",
 *              "normalization_context"={
 *                  "groups" = {"get_author_role_member"}
 *              }
 *          },
 *          "post"={
 *              "method",
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous n'avez pas les droits",
 *              "denormalisation_context"={
 *                  "groups"={"put_manager"}
 *              }
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "method"="GET",
 *              "normalization_context"={
 *                  "groups"={"get_author_role_member"}
 *              }
 *          },
 *          "put"={
 *              "method"="PUT",
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="vous n'avez pas les droits",
 *              "denormalization_context"={
 *                  "groups"={"put_manager"}
 *               }
 *           },
 *          "delete"={
 *              "method"="DELETE",
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous n'avez pas les droits"
 *          }
 *      }
 * )
 * @ApiFilter(
 *      SearchFilter::class,
 *      properties={
 *          "lastname":"ipartial",
 *          "firstname":"ipartial",
 *          "nationality":"exact"
 *      }
 * )
 */
class Author
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_author_role_member"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_author_role_member", "put_manager"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get_author_role_member", "put_manager"})
     */
    private $lastname;

    /**
     * @ORM\ManyToOne(targetEntity=Nationality::class, inversedBy="authors")
     * @Groups({"get_author_role_member", "put_manager"})
     */
    private $nationality;

    /**
     * @ORM\OneToMany(targetEntity=Book::class, mappedBy="author")
     * @Groups({"get_author_role_member"})
     */
    private $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->firstname.' '.$this->lastname;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }


    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getNationality(): ?Nationality
    {
        return $this->nationality;
    }

    public function setNationality(?Nationality $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setAuthor($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getAuthor() === $this) {
                $book->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * Permet de compter le nombre de livres de chaque auteur
     *
     * @Groups({"get"})
     * 
     * @return integer
     */
    public function getNbBooks(): int
    {
        return $this->books->count();
    }

    /**
     * Retourne le nombre de livre disponible de cette autheur
     * 
     * @Groups({"get"})
     *
     * @return integer
     */
    public function getNbBookAvailable():int
    {
        return array_reduce($this->books->toArray(), function($nb, $book){
            return $nb + ($book->getBookRents() === true ? 1 : 0);
        }, 0);
    }
}
