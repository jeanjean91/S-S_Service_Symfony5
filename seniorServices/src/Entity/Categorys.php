<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorysRepository")
 */
class Categorys
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
    private $nomCat;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Services", mappedBy="categorys")
     */
    private $service;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorys", inversedBy="categorys")
     *  @ORM\JoinColumn(name="categorys_id", referencedColumnName="id")
     * @ORM\joinColumn(onDelete="SET NULL")
     */
    private $sousCategory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Categorys", mappedBy="sousCategory")
     * @ORM\joinColumn(onDelete="SET NULL")
     */
    private $categorys;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Categorys", mappedBy="categorys")
     */
    private $sousSousCategory;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $niveau;



    public function __construct()
    {
        $this->service = new ArrayCollection();
        $this->categorys = new ArrayCollection();
        $this->sousSousCategory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCat(): ?string
    {
        return $this->nomCat;
    }

    public function setNomCat(string $nomCat): self
    {
        $this->nomCat = $nomCat;

        return $this;
    }


    /**
     * @return Collection|Services[]
     */

    public function getService(): Collection
    {
        return $this->service;
    }

    public function addService(Services $service): self
    {
        if (!$this->service->contains($service)) {
            $this->service[] = $service;
            $service->setCategorys($this);
        }

        return $this;
    }

    public function removeService(Services $service): self
    {
        if ($this->service->contains($service)) {
            $this->service->removeElement($service);
            // set the owning side to null (unless already changed)
            if ($service->getCategorys() === $this) {
                $service->setCategorys(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->sousCategory;
    }

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

    public function getCategorys(): Collection
    {
        return $this->categorys;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(?int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }
}
