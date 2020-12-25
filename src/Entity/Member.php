<?php

namespace App\Entity;

use App\Entity\Role;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MemberRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=MemberRepository::class)
 * @ApiResource(
 *      collectionOperations={
 *       "get"={
 *          "method" = "GET",
 *           "path" = "/members",
 *           "security"="is_granted('ROLE_MANAGER')",
 *           "security_message"="Vous ne pouvez avoir accès a tous les membres.",           
 *        },
 *       "post"={
 *           "method" = "POST",
 *           "security"="is_granted('ROLE_MANAGER')",
 *           "security_message"="Vous ne pouvez avoir accès a tous les membres.", 
 *           "normalization_context" = {
 *              "groups" = {"post_manager"},
 *           } 
 *        }
 *   },
 * itemOperations={
 *       "get"={
 *           "method"="GET",
 *           "path"="/member/{id}",
 *              "security"="is_granted('ROLE_USER') and object.getMember() == user or is_granted('ROLE_MANAGER')",
 *              "security_message"="Vous ne pouvez avoir accès qu'a vos propres prêts.",
 *               "normalizationContext" = {
 *                   "groups" = {"get_role_member"}
 *               }
 *           },
 *           "put"={
 *               "method" = "PUT",
 *               "path" = "/bookrent/{id}",
 *               "security"="is_granted('ROLE_USER') and object.getMember() == user or is_granted('ROLE_MANAGER')",
 *              "security_message"="Vous ne pouvez avoir accès qu'a vos propres prêts.",
 *               "denormalizationContext" = {
 *                   "groups"={"put_member"}
 *               }
 *           },
 *           "delete_admin"={
 *               "method" = "DELETE",
 *               "path" = "/bookrent/{id}",
 *               "security"="is_granted('ROLE_ADMIN')",
 *               "security_message"="Vous n'avez pas les droits d'acceder à cette ressource"
 *           }  
 *       }
 * )
 * @UniqueEntity("mail", message="Il existe déja ce mail {{ value }} veuillez saisir un autre mail")
 * 
 */
class Member implements UserInterface
{ 
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post_manager", "get_role_member","put_member", "put_manager"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post_manager", "get_role_member","put_member", "put_manager"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"post_manager", "get_role_member","put_member", "put_manager"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"post_manager", "get_role_member","put_member", "put_manager"})
     */
    private $communeCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post_manager", "get_role_member"})
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"post_manager", "get_role_member","put_member", "put_manager"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post_manager","put_member"})
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=BookRent::class, mappedBy="member")
     * @Groups({"get_role_member","put_member","put_manager"})
     * @ApiSubresource
     */
    private $bookRents;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="members")
     * 
     */
    private $roles;   

    public function __construct()
    {
        $this->bookRents = new ArrayCollection();
        $this->roles     = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCommuneCode(): ?string
    {
        return $this->communeCode;
    }

    public function setCommuneCode(?string $communeCode): self
    {
        $this->communeCode = $communeCode;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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
            $bookRent->setMember($this);
        }

        return $this;
    }

    public function removeBookRent(BookRent $bookRent): self
    {
        if ($this->bookRents->removeElement($bookRent)) {
            // set the owning side to null (unless already changed)
            if ($bookRent->getMember() === $this) {
                $bookRent->setMember(null);
            }
        }

        return $this;
    }

    public function getRoles()
    {
        $roles = $this->roles->map(function($role){
            return $role->getTitle();
        })->toArray();
        $roles[] = "ROLE_USER";
        // dd($roles);
        return $roles;
    }
   
    public function getSalt(){}

    public function getUsername()
    {
        return $this->mail;
    }

    public function eraseCredentials(){}

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->getMembers($this);
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->roles->removeElement($role)) {
            // set the owning side to null (unless already changed)
            if ($role->getMembers() === $this) {
                $role->getMembers(null);
            }
        }

        return $this;
    }

}
