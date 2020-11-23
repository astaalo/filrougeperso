<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfilsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfilsRepository::class)
 * @ApiResource(
 * normalizationContext={"groups"={"profil:read"}},
 * attributes={
 *       "security"="is_granted('ROLE_ADMIN')",
 *       "security_message"="Vous n'avez pas access à cette Ressource"
 * },
 *     collectionOperations={
 *     "get","post",
 * "get_role_admin"={
 * "method"="GET",
 * "path"="/admin/profils" ,
 * },
 * "get_role_admin"={
 * "method"="POST",
 * "path"="/admin/profils" ,
 * },
 * "get_role_admin"={
 * "method"="GET",
 * "path"="/admin/profils/id/users" ,
 * },
 * },
 * itemOperations={
 * "get_role_admin"={
 * "method"="GET",
 * "path"="/admin/profils/{id}" ,
 * },
 *   "delete_role_admin"={
 *  "method"="DELETE",
 *  "path"="/admin/profils/{id}",
 *},
 *  "get_admin_put"={
 * "method"="PUT",
 * "path"="/admin/profils/{id}" ,
 * },
 * }
 * )
 */
class Profils
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     */
    private $users;

    /**
     * @ORM\Column(type="boolean")
     */
    private $IsDeleted;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setProfil($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->IsDeleted;
    }

    public function setIsDeleted(bool $IsDeleted): self
    {
        $this->IsDeleted = $IsDeleted;

        return $this;
    }
}
