<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\ORM\Mappin\Annotation\joinColumn;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ServicesRepository")
 */
class Services
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $region;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prixTTC;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorys", inversedBy="service")
     * @var Collection
     */
    private $categorys;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Reservation", mappedBy="service", cascade={"persist", "remove"})
     *
     */
    private $reservation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detail", mappedBy="service", orphanRemoval=true)
     * @var Collection
     */
    private $details;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", inversedBy="service")
     */
    private $commande;

    public function __construct()
    {
        $this->details = new ArrayCollection();
        $this->categorys = new ArrayCollection();

    }

    public function __toString()
    {
        return (string)$this->reservation;
    }

    /* public function __toString() {
         return $this->Service;
     }*/

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection|Detail[]
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setService($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): self
    {
        if ($this->details->contains($detail)) {
            $this->details->removeElement($detail);
            // set the owning side to null (unless already changed)
            if ($detail->getService() === $this) {
                $detail->setService(null);
            }
        }

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getPrixTTC(): ?int
    {
        return $this->prixTTC;
    }

    public function setPrixTTC(?int $prixTTC): self
    {
        $this->prixTTC = $prixTTC;

        return $this;
    }


    /*public function __toString()
    {
        return $this->sousCategory;
    }*/

    public function getSousCategory(): ?self
    {
        return $this->sousCategory;
    }

    public function setSousCategory(?self $sousCategory): self
    {
        $this->sousCategory = $sousCategory;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    /*public function __toString()
    {
        return $this->categorys;
    }*/

    public function getCategorys(Doctrine\Common\Collections\Collection $collection)
    {
          $this->categorys = $collection;
        return $this ;


    }

    public function addCategory(self $category): self
    {
        if (!$this->categorys->contains($category)) {
            $this->categorys[] = $category;
            $category->setSousCategory($this);
        }

        return $this;
    }

    public function removeCategory(self $category): self
    {
        if ($this->categorys->contains($category)) {
            $this->categorys->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getSousCategory() === $this) {
                $category->setSousCategory(null);
            }
        }

        return $this;
    }

    public function setCategorys(?self $categorys): self
    {
        $this->categorys = $categorys;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSousSousCategory(): Collection
    {
        return $this->sousSousCategory;
    }

    public function addSousSousCategory(self $sousSousCategory): self
    {
        if (!$this->sousSousCategory->contains($sousSousCategory)) {
            $this->sousSousCategory[] = $sousSousCategory;
            $sousSousCategory->setCategorys($this);
        }

        return $this;
    }

    public function removeSousSousCategory(self $sousSousCategory): self
    {
        if ($this->sousSousCategory->contains($sousSousCategory)) {
            $this->sousSousCategory->removeElement($sousSousCategory);
            // set the owning side to null (unless already changed)
            if ($sousSousCategory->getCategorys() === $this) {
                $sousSousCategory->setCategorys(null);
            }
        }

        return $this;
    }


    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }
    public function setReservation()
    {
        return $this->reservation;
    }

    /*public function setReservation(?Reservation $user): strind
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newService = null === $user ? null : $this;
        if ($user->getService() !== $newService) {
            $user->setService($newService);
        }

        return $this;
    }*/
}
