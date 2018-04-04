<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BonPlanBundle;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Publicite
 *
 * @ORM\Table(name="publicite", indexes={@ORM\Index(name="id_etablissement", columns={"id_etablissement"})})
 * @ORM\Entity(repositoryClass="PubliciteBundle\Repository\PubliciteRipository")
 */
class Publicite
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_publicite", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPublicite;

    /**
     * @var string
     *
     * @ORM\Column(name="description_publicite", type="string", length=2000, nullable=false)
     */
    private $descriptionPublicite;

    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg" , "image/png"})
     * @ORM\Column(name="photo_publicite", type="string", length=2000, nullable=false)
     */
    private $photoPublicite;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=20, nullable=false)
     */
    private $titre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="date", nullable=false)
     */
    private $datedebut;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_click", type="integer", nullable=true)
     */
    private $nbrClick;

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
    public function getIdPublicite()
    {
        return $this->idPublicite;
    }

    /**
     * @param int $idPublicite
     */
    public function setIdPublicite($idPublicite)
    {
        $this->idPublicite = $idPublicite;
    }

    /**
     * @return string
     */
    public function getDescriptionPublicite()
    {
        return $this->descriptionPublicite;
    }

    /**
     * @param string $descriptionPublicite
     */
    public function setDescriptionPublicite($descriptionPublicite)
    {
        $this->descriptionPublicite = $descriptionPublicite;
    }

    /**
     * @return string
     */
    public function getPhotoPublicite()
    {
        return $this->photoPublicite;
    }

    /**
     * @param string $photoPublicite
     */
    public function setPhotoPublicite($photoPublicite)
    {
        $this->photoPublicite = $photoPublicite;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return \DateTime
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * @param \DateTime $datedebut
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;
    }

    /**
     * @return int
     */
    public function getNbrClick()
    {
        return $this->nbrClick;
    }

    /**
     * @param int $nbrClick
     */
    public function setNbrClick($nbrClick)
    {
        $this->nbrClick = $nbrClick;
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

