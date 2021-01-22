<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookRentRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BookRentRepository::class)
 * @ApiResource(
 *  attributes={
 *      "order"={
 *          "dateRent":"ASC"
 *      }
 *  },
 *  collectionOperations={
 *       "get"={
 *          "method" = "GET",
 *           "path" = "/booksrent",
 *           "security" = "is_granted('ROLE_MANAGER')",
 *           "security_message" = "Vous ne pouvez avoir accès a tous les pret.",           
 *        },
 *       "post"={
 *           "method" = "POST",  
 *           "path" = "/booksrent",
 *           "denormalizationContext"= {
 *                "groups" = {"rent_post_role_member"}
 *           }
 *        }
 *   },
 *   itemOperations={
 *       "get"={
 *           "method"="GET",
 *           "path"="/bookrent/{id}",
 *              "security"="is_granted('ROLE_USER') and object.getMember() == user or is_granted('ROLE_MANAGER')",
 *              "security_message"="Vous ne pouvez avoir accès qu'a vos propres prêts.",
 *               "normalizationContext" = {
 *                   "groups" = {"get_role_member"}
 *               }
 *           },
 *           "put"={
 *               "method" = "PUT",
 *               "path" = "/bookrent/{id}",
 *               "security"="is_granted('ROLE_MANAGER')",
 *               "security_message"="Vous n'avez pas les droits d'acceder à cette ressource",
 *               "denormalizationContext" = {
 *                   "groups"={"put_manager"}
 *               }
 *           },
 *           "delete_admin"={
 *               "method" = "DELETE",
 *               "path" = "/bookrent/{id}",
 *               "security"="is_granted('ROLE_ADMIN')",
 *               "security_message"="Vous n'avez pas les droits d'acceder à cette ressource"
 *           }  
 *    }
 * )
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
     * @Groups({"get_role_manager","get_role_member"})
     */
    private $dateRent;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get_role_manager","put_manager","get_role_member"})
     */
    private $dateReturn;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"put_manager","get_role_manager","get_role_member"})
     */
    private $dateRealReturn;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="bookRents")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"rent_post_role_member","get_role_member"})
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity=Member::class, inversedBy="bookRents")
     * @Groups({"get_role_manager"})
     */
    private $member;

    public function __construct()
    {
        $this->dateRent       = new \DateTime();
        $dateReturn           = date('Y-m-d' , strtotime('15 days', $this->getDateRent()->getTimestamp()));
        $this->dateReturn     = \DateTime::createFromFormat('Y-m-d', $dateReturn); 
        $this->dateRealReturn = null;
    }

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
