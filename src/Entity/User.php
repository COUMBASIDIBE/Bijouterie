<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *          message="Un compte existe déjà avec cette adresse mail"
 * )
 * @method string getUserIdentifier()
 */
class User implements UserInterface
{
    // Notre class User herite a présent de UserInterface qui impose à User de possèdé 5 methodes obligatoirement : getPassword(), GetUsername(), getSalt(),getRoles() et eraseCreadentials()
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="veuillez remplir ce champs")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="veuillez remplir ce champs")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="veuillez remplir ce champs")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="veuillez remplir ce champs")
     * @Assert\Email(message="Merci de rentrer un email valide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="veuillez remplir ce champs")
     * @Assert\EqualTo(propertyPath="confirm_password", message="les mots de passe ne correspondent pas")
     */
    private $password;

    public $confirm_password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = ["ROLE_USER"];

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="user")
     */
    private $commandes;

    /**
     * @ORM\Column(type="integer")
     */
    private $promo;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_inscription;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
//getSalt renvoie la chaine de caratère saisie par l'utilisateur et non encodée à l'encoder pour qu'il procède au hashage du mot de passe
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }
//cette methode vise à nettoyer les mots de passe en text brut(non hashé) eventuellement stocké en BDD
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
    }

    public function getPromo(): ?int
    {
        return $this->promo;
    }

    public function setPromo(int $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(?\DateTimeInterface $date_inscription): self
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }
}
