<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Lieux
 *
 * @ORM\Table(name="lieux")
 * @ORM\Entity(repositoryClass="App\Repository\LieuxRepository")
 *
 */
class Lieux
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_lieu", type="string", length=30, nullable=false)
     */
    private $nomLieu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rue", type="string", length=30, nullable=true)
     */
    private $rue;

    /**
     * @var float|null
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $latitude;

    /**
     * @var float|null
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $longitude;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Villes", inversedBy="lieux", cascade={"remove", "persist"})
     * @ORM\JoinColumn(name="Villes", referencedColumnName="id", onDelete="cascade")
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sorties", mappedBy="lieu")
     * @ORM\JoinColumn(name="Sorties", referencedColumnName="id")
     */
    private $listSorties;

    public function __construct()
    {
        $this->listSorties = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNomLieu(): ?string
    {
        return $this->nomLieu;
    }

    /**
     * @param string $nomLieu
     */
    public function setNomLieu(string $nomLieu): void
    {
        $this->nomLieu = $nomLieu;
    }

    /**
     * @return string|null
     */
    public function getRue(): ?string
    {
        return $this->rue;
    }

    /**
     * @param string|null $rue
     */
    public function setRue(?string $rue): void
    {
        $this->rue = $rue;
    }

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param float|null $latitude
     */
    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float|null $longitude
     */
    public function setLongitude(?float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     */
    public function setVille($ville): void
    {
        $this->ville = $ville;
    }

    /**
     * @return Collection|Sorties[]
     */
    public function getListSorties(): Collection
    {
        return $this->listSorties;
    }

    public function addListSorty(Sorties $listSorty): self
    {
        if (!$this->listSorties->contains($listSorty)) {
            $this->listSorties[] = $listSorty;
            $listSorty->setLieu($this);
        }

        return $this;
    }

    public function removeListSorty(Sorties $listSorty): self
    {
        if ($this->listSorties->contains($listSorty)) {
            $this->listSorties->removeElement($listSorty);
            // set the owning side to null (unless already changed)
            if ($listSorty->getLieu() === $this) {
                $listSorty->setLieu(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNomLieu();
    }


}