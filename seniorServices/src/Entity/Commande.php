<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $client;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detail", mappedBy="commande")
     */
    private $details;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detail", mappedBy="commande", orphanRemoval=true)
     */
    private $service;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Services", mappedBy="commande")
     */
    private $services;


    public function __construct()
    {
        $this->details = new ArrayCollection();
        $this->service = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->date = new \Datetime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Detail[]
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addService(Detail $service): self
    {
        if (!$this->produit->contains($service)) {
            $this->service[] = $service;
            $service->setCommande($this);
        }


        return $this;
    }

    public function removeDetail(Detail $detail): self
    {
        if ($this->details->contains($detail)) {
            $this->details->removeElement($detail);
            // set the owning side to null (unless already changed)
            if ($detail->getCommande() === $this) {
                $detail->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Detail[]
     */
    public function getService(): Collection
    {
        return $this->getService();
    }

    public function removeService(Detail $service): self
    {
        if ($this->produit->contains($service)) {
            $this->produit->removeElement($service);
            // set the owning side to null (unless already changed)
            if ($service->getCommande() === $this) {
                $service->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Services[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }
}
