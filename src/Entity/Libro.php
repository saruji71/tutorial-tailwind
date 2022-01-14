<?php

namespace App\Entity;

use App\Repository\LibroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LibroRepository::class)]
class Libro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $titulo;

    #[ORM\Column(type: 'string', length: 50)]
    private $autor;

    #[ORM\OneToMany(mappedBy: 'libro', targetEntity: Capitulo::class, orphanRemoval: true)]
    private $capitulo;

    public function __construct()
    {
        $this->capitulo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(string $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * @return Collection|Capitulo[]
     */
    public function getCapitulo(): Collection
    {
        return $this->capitulo;
    }

    public function addCapitulo(Capitulo $capitulo): self
    {
        if (!$this->capitulo->contains($capitulo)) {
            $this->capitulo[] = $capitulo;
            $capitulo->setLibro($this);
        }

        return $this;
    }

    public function removeCapitulo(Capitulo $capitulo): self
    {
        if ($this->capitulo->removeElement($capitulo)) {
            // set the owning side to null (unless already changed)
            if ($capitulo->getLibro() === $this) {
                $capitulo->setLibro(null);
            }
        }

        return $this;
    }
}
