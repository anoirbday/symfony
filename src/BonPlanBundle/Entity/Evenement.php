<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BonPlanBundle;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="id_etablissement", columns={"id_etablissement"})})
 * @ORM\Entity(repositoryClass="BonPlanBundle\Repository\EvenementRepository")
 */
class Evenement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_evenement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $idEvenement;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_evenement", type="string", length=30, nullable=false)
     */
    public $nomEvenement;

    /**
     * @var string
     *
     * @ORM\Column(name="description_evenement", type="string", length=3000, nullable=false)
     */
    public $descriptionEvenement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_evenement", type="date", nullable=false)
     */
    public $dateEvenement;

    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg" })
     * @ORM\Column(name="photo_evenement", type="string", length=2000, nullable=false)
     */
    public $photoEvenement;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombre_participant", type="integer", nullable=true)
     */
    public $nombreParticipant;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombre_interesse", type="integer", nullable=true)
     */
    public $nombreInteresse;

    /**
     * @return int
     */
    public function getIdEvenement()
    {
        return $this->idEvenement;
    }

    /**
     * @param int $idEvenement
     */
    public function setIdEvenement($idEvenement)
    {
        $this->idEvenement = $idEvenement;
    }

    /**
     * @return string
     */
    public function getNomEvenement()
    {
        return $this->nomEvenement;
    }

    /**
     * @param string $nomEvenement
     */
    public function setNomEvenement($nomEvenement)
    {
        $this->nomEvenement = $nomEvenement;
    }

    /**
     * @return string
     */
    public function getDescriptionEvenement()
    {
        return $this->descriptionEvenement;
    }

    /**
     * @param string $descriptionEvenement
     */
    public function setDescriptionEvenement($descriptionEvenement)
    {
        $this->descriptionEvenement = $descriptionEvenement;
    }

    /**
     * @return \DateTime
     */
    public function getDateEvenement()
    {
        return $this->dateEvenement;
    }

    /**
     * @param \DateTime $dateEvenement
     */
    public function setDateEvenement($dateEvenement)
    {
        $this->dateEvenement = $dateEvenement;
    }

    /**
     * @return string
     */
    public function getPhotoEvenement()
    {
        return $this->photoEvenement;
    }

    /**
     * @param string $photoEvenement
     */
    public function setPhotoEvenement($photoEvenement)
    {
        $this->photoEvenement = $photoEvenement;
    }

    /**
     * @return int
     */
    public function getNombreParticipant()
    {
        return $this->nombreParticipant;
    }

    /**
     * @param int $nombreParticipant
     */
    public function setNombreParticipant($nombreParticipant)
    {
        $this->nombreParticipant = $nombreParticipant;
    }

    /**
     * @return int
     */
    public function getNombreInteresse()
    {
        return $this->nombreInteresse;
    }

    /**
     * @param int $nombreInteresse
     */
    public function setNombreInteresse($nombreInteresse)
    {
        $this->nombreInteresse = $nombreInteresse;
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

    /**
     * @var BonPlanBundle\Entity\Etablissement
     *
     * @ORM\ManyToOne(targetEntity="Etablissement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_etablissement", referencedColumnName="id_etablissement")
     * })
     */
    public $idEtablissement;


}

