<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookRentRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=BookRentRepository::class)
 * @ApiResource()
 */
class BookRent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateRent;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateReturn;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateRealReturn;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="bookRents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity=Member::class, inversedBy="bookRents")
     */
    private $member;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRent(): ?\DateTimeInterface
    {
        return $this->dateRent;
    }

    public function setDateRent(\DateTimeInterface $dateRent): self
    {
        $this->dateRent = $dateRent;

        return $this;
    }

    public function getDateReturn(): ?\DateTimeInterface
    {
        return $this->dateReturn;
    }

    public function setDateReturn(\DateTimeInterface $dateReturn): self
    {
        $this->dateReturn = $dateReturn;

        return $this;
    }

    public function getDateRealReturn(): ?\DateTimeInterface
    {
        return $this->dateRealReturn;
    }

    public function setDateRealReturn(?\DateTimeInterface $dateRealReturn): self
    {
        $this->dateRealReturn = $dateRealReturn;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }
}
