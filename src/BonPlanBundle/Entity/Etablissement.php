<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BonPlanBundle;
/**
 * Etablissement
 *
 * @ORM\Table(name="etablissement", uniqueConstraints={@ORM\UniqueConstraint(name="adresse", columns={"adresse_etablissement"})}, indexes={@ORM\Index(name="id_categorie", columns={"id_categorie"}), @ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="BonPlanBundle\Repository\EtablissementRepository")
 */
class Etablissement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_etablissement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEtablissement;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_etablissement", type="string", length=200, nullable=false)
     */
    private $nomEtablissement;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_etablissement", type="string", length=200, nullable=false)
     */
    private $adresseEtablissement;

    /**
     * @var integer
     *
     * @ORM\Column(name="telephone_etablissement", type="integer", nullable=false)
     */
    private $telephoneEtablissement;

    /**
     * @var string
     *
     * @ORM\Column(name="horaire_travail", type="string", length=100, nullable=false)
     */
    private $horaireTravail;

    /**
     * @var string
     *
     * @ORM\Column(name="description_etablissement", type="string", length=3000, nullable=false)
     */
    private $descriptionEtablissement;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_etablissement", type="string", length=2000, nullable=false)
     */
    private $photoEtablissement;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_patente", type="string", length=2000, nullable=false)
     */
    private $photoPatente;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_postal", type="integer", nullable=false)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="budget", type="string", nullable=false)
     */
    private $budget;

    /**
     * @var string
     *
     * @ORM\Column(name="site_web", type="string", length=100, nullable=true)
     */
    private $siteWeb;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=false)
     */
    private $longitude;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=false)
     */
    private $latitude;

    /**
     * @var BonPlanBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;

    /**
     * @var BonPlanBundle\Entity\Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie", referencedColumnName="id_categorie")
     * })
     */
    private $idCategorie;

    /**
     * @return int
     */
    public function getIdEtablissement()
    {
        return $this->idEtablissement;
    }

    /**
     * @param int $idEtablissement
     */
    public function setIdEtablissement($idEtablissement)
    {
        $this->idEtablissement = $idEtablissement;
    }

    /**
     * @return string
     */
    public function getNomEtablissement()
    {
        return $this->nomEtablissement;
    }

    /**
     * @param string $nomEtablissement
     */
    public function setNomEtablissement($nomEtablissement)
    {
        $this->nomEtablissement = $nomEtablissement;
    }

    /**
     * @return string
     */
    public function getAdresseEtablissement()
    {
        return $this->adresseEtablissement;
    }

    /**
     * @param string $adresseEtablissement
     */
    public function setAdresseEtablissement($adresseEtablissement)
    {
        $this->adresseEtablissement = $adresseEtablissement;
    }

    /**
     * @return int
     */
    public function getTelephoneEtablissement()
    {
        return $this->telephoneEtablissement;
    }

    /**
     * @param int $telephoneEtablissement
     */
    public function setTelephoneEtablissement($telephoneEtablissement)
    {
        $this->telephoneEtablissement = $telephoneEtablissement;
    }

    /**
     * @return string
     */
    public function getHoraireTravail()
    {
        return $this->horaireTravail;
    }

    /**
     * @param string $horaireTravail
     */
    public function setHoraireTravail($horaireTravail)
    {
        $this->horaireTravail = $horaireTravail;
    }

    /**
     * @return string
     */
    public function getDescriptionEtablissement()
    {
        return $this->descriptionEtablissement;
    }

    /**
     * @param string $descriptionEtablissement
     */
    public function setDescriptionEtablissement($descriptionEtablissement)
    {
        $this->descriptionEtablissement = $descriptionEtablissement;
    }

    /**
     * @return string
     */
    public function getPhotoEtablissement()
    {
        return $this->photoEtablissement;
    }

    /**
     * @param string $photoEtablissement
     */
    public function setPhotoEtablissement($photoEtablissement)
    {
        $this->photoEtablissement = $photoEtablissement;
    }

    /**
     * @return string
     */
    public function getPhotoPatente()
    {
        return $this->photoPatente;
    }

    /**
     * @param string $photoPatente
     */
    public function setPhotoPatente($photoPatente)
    {
        $this->photoPatente = $photoPatente;
    }

    /**
     * @return int
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param int $codePostal
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
    }

    /**
     * @return string
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @param string $budget
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;
    }

    /**
     * @return string
     */
    public function getSiteWeb()
    {
        return $this->siteWeb;
    }

    /**
     * @param string $siteWeb
     */
    public function setSiteWeb($siteWeb)
    {
        $this->siteWeb = $siteWeb;
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
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return User
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param User $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Categorie
     */
    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    /**
     * @param Categorie $idCategorie
     */
    public function setIdCategorie($idCategorie)
    {
        $this->idCategorie = $idCategorie;
    }


}

