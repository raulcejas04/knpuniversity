<?php

namespace App\Entity;

use App\Repository\PersonaJuridicaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=PersonaJuridicaRepository::class)
 */
class PersonaJuridica
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
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity=Representacion::class, mappedBy="personaJuridica")
     */
    private $representaciones;

    public function __construct()
    {
        $this->representaciones = new ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->getNombre();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return Collection|Representacion[]
     */
    public function getRepresentaciones(): Collection
    {
        return $this->representaciones;
    }

    public function addRepresentacione(Representacion $representacione): self
    {
        if (!$this->representaciones->contains($representacione)) {
            $this->representaciones[] = $representacione;
            $representacione->setPersonaJuridica($this);
        }

        return $this;
    }

    public function removeRepresentacione(Representacion $representacione): self
    {
        if ($this->representaciones->removeElement($representacione)) {
            // set the owning side to null (unless already changed)
            if ($representacione->getPersonaJuridica() === $this) {
                $representacione->setPersonaJuridica(null);
            }
        }

        return $this;
    }

}
