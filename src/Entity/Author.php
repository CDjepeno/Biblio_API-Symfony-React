<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AuthorRepository::class)
 * @ApiResource()
 */
class Author
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"listAuthorFull","listAuthorSimple"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"listAuthorFull","listAuthorSimple"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"listAuthorFull","listAuthorSimple"})
     */
    private $lastname;

    /**
     * @ORM\ManyToOne(targetEntity=Nationality::class, inversedBy="authors")
     * @Groups({"listAuthorFull","listAuthorSimple"})
     */
    private $nationality;

    /**
     * @ORM\OneToMany(targetEntity=Book::class, mappedBy="author")
     * @Groups({"listAuthorFull"})
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
}
