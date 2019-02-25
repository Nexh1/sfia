<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SavoirFaireRepository")
 */
class SavoirFaire
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
    private $nomFr;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomEn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomGer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFr(): ?string
    {
        return $this->nomFr;
    }

    public function setNomFr(string $nomFr): self
    {
        $this->nomFr = $nomFr;

        return $this;
    }

    public function getNomEn(): ?string
    {
        return $this->nomEn;
    }

    public function setNomEn(?string $nomEn): self
    {
        $this->nomEn = $nomEn;

        return $this;
    }

    public function getNomGer(): ?string
    {
        return $this->nomGer;
    }

    public function setNomGer(?string $nomGer): self
    {
        $this->nomGer = $nomGer;

        return $this;
    }
}
