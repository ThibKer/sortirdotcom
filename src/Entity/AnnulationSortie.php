<?php

namespace App\Entity;

use App\Repository\AnnulationSortieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnulationSortieRepository::class)
 */
class AnnulationSortie
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
     * @ORM\OneToOne(targetEntity=Sortie::class, inversedBy="annulationSortie", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $sortie;

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

    public function getSortie(): ?Sortie
    {
        return $this->sortie;
    }

    public function setSortie(Sortie $sortie): self
    {
        $this->sortie = $sortie;

        return $this;
    }
}
