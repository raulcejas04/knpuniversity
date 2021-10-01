<?php

namespace App\Entity;

use App\Repository\PersonaFisicaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonaFisicaRepository::class)
 */
class PersonaFisica
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
    private $apellido;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombres;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nroDoc;

    /**
     * @ORM\Column(type="integer")
     */
    private $cuitCuil;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fechaNac;
        /**
     * @ORM\ManyToOne(targetEntity=Sexo::class, inversedBy="personasFisicas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sexo;

    /**
     * @ORM\ManyToOne(targetEntity=EstadoCivil::class, inversedBy="personasFisicas")
     */
    private $estadoCivil;

    /**
     * @ORM\ManyToOne(targetEntity=Nacionalidad::class, inversedBy="personasFisicas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nacionalidad;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="personasFisicas", cascade={"persist", "remove"})
     */
    private $usuario;

    /**
     * @ORM\OneToMany(targetEntity=Representacion::class, mappedBy="personaFisica")
     */
    private $representaciones;

    public function __construct()
    {
        $this->representaciones = new ArrayCollection();
    }
    

    public function __toString()
       {
        $a = $this->getApellido() . ", " . $this->getNombres() . " (" . $this->getCuitCuil() . ")";
        return $a;
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): self
    {
        $this->nombres = $nombres;

        return $this;
    }

    public function getNroDoc(): ?string
    {
        return $this->nroDoc;
    }

    public function setNroDoc(string $nroDoc): self
    {
        $this->nroDoc = $nroDoc;

        return $this;
    }

    public function getCuitCuil(): ?int
    {
        return $this->cuitCuil;
    }

    public function setCuitCuil(int $cuitCuil): self
    {
        $this->cuitCuil = $cuitCuil;

        return $this;
    }

    public function getFechaNac(): ?\DateTimeInterface
    {
        return $this->fechaNac;
    }

    public function setFechaNac(?\DateTimeInterface $fechaNac): self
    {
        $this->fechaNac = $fechaNac;
        return $this;
    }

    
    public function getSexo(): ?Sexo
    {
        return $this->sexo;
    }

    public function setSexo(?Sexo $sexo): self
    {
        $this->sexo = $sexo;

        return $this;
    }

    public function getEstadoCivil(): ?EstadoCivil
    {
        return $this->estadoCivil;
    }

    public function setEstadoCivil(?EstadoCivil $estadoCivil): self
    {
        $this->estadoCivil = $estadoCivil;

        return $this;
    }

    public function getNacionalidad(): ?Nacionalidad
    {
        return $this->nacionalidad;
    }

    public function setNacionalidad(?Nacionalidad $nacionalidad): self
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): self
    {
        $this->usuario = $usuario;

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
            $representacione->setPersonaFisica($this);
        }

        return $this;
    }

    public function removeRepresentacione(Representacion $representacione): self
    {
        if ($this->representaciones->removeElement($representacione)) {
            // set the owning side to null (unless already changed)
            if ($representacione->getPersonaFisica() === $this) {
                $representacione->setPersonaFisica(null);
            }
        }

        return $this;
    }

}
