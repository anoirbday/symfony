<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BonPlanBundle;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Offre
 *
 * @ORM\Table(name="offre", indexes={@ORM\Index(name="id_etablissement", columns={"id_etablissement"})})
 * @ORM\Entity(repositoryClass="yassineBundle\Repository\OffreRepository")
 */
class Offre
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_offre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOffre;

    /**
     * @var string
     *
     * @ORM\Column(name="titre_offre", type="string", length=100, nullable=false)
     */
    private $titreOffre;

    /**
     * @var string
     *
     * @ORM\Column(name="description_offre", type="text", nullable=false)
     */
    private $descriptionOffre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @Assert\File(mimeTypes={ "image/jpeg" , "image/png"})
     * @var string
     * @ORM\Column(name="photo_offre", type="string", length=2000, nullable=false)
     */
    private $photoOffre;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombre_like", type="integer", nullable=true)
     */
    private $nombreLike;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombre_dislike", type="integer", nullable=true)
     */
    private $nombreDislike;

    /**
     * @var BonPlanBundle\Entity\Etablissement
     *
     * @ORM\ManyToOne(targetEntity="Etablissement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_etablissement", referencedColumnName="id_etablissement")
     * })
     */
    private $idEtablissement;

    /**
     * @return int
     */
    public function getIdOffre()
    {
        return $this->idOffre;
    }

    /**
     * @param int $idOffre
     */
    public function setIdOffre($idOffre)
    {
        $this->idOffre = $idOffre;
    }

    /**
     * @return string
     */
    public function getTitreOffre()
    {
        return $this->titreOffre;
    }

    /**
     * @param string $titreOffre
     */
    public function setTitreOffre($titreOffre)
    {
        $this->titreOffre = $titreOffre;
    }

    /**
     * @return string
     */
    public function getDescriptionOffre()
    {
        return $this->descriptionOffre;
    }

    /**
     * @param string $descriptionOffre
     */
    public function setDescriptionOffre($descriptionOffre)
    {
        $this->descriptionOffre = $descriptionOffre;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTime $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return string
     */
    public function getPhotoOffre()
    {
        return $this->photoOffre;
    }

    /**
     * @param string $photoOffre
     */
    public function setPhotoOffre($photoOffre)
    {
        $this->photoOffre = $photoOffre;
    }

    /**
     * @return int
     */
    public function getNombreLike()
    {
        return $this->nombreLike;
    }

    /**
     * @param int $nombreLike
     */
    public function setNombreLike($nombreLike)
    {
        $this->nombreLike = $nombreLike;
    }

    /**
     * @return int
     */
    public function getNombreDislike()
    {
        return $this->nombreDislike;
    }

    /**
     * @param int $nombreDislike
     */
    public function setNombreDislike($nombreDislike)
    {
        $this->nombreDislike = $nombreDislike;
    }

    /**
     * @return Etablissement
     */
    public function getIdEtablissement()
    {
        return $this->idEtablissement;
    }

    /**
     * @param Etablissement $idEtablissement
     */
    public function setIdEtablissement($idEtablissement)
    {
        $this->idEtablissement = $idEtablissement;
    }


}

