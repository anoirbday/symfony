<?php

namespace ExpEvalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use BonPlanBundle;
/**
 * Experience
 * @ORM\Table(name="experience", indexes={@ORM\Index(name="id_etablissement", columns={"id_etablissement"}), @ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="ExpEvalBundle\Repository\ExperienceRepository")
 **/
class Experience
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_exp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idExp;

    /**
     * @var string
     *
     * @ORM\Column(name="description_experience", type="string", length=1200, nullable=true)
     */
    private $descriptionExperience;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez ajouter une photo!")
     * @Assert\Image()
     * @ORM\Column(name="preuve", type="string", length=2000, nullable=true)
     */
    private $preuve;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_exp", type="date", nullable=true)
     */
    private $dateExp;

    /**
     * @var BonPlanBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="BonPlanBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
     private $id;

    /**
     * @var BonPlanBundle\Entity\Etablissement
     *
     * @ORM\ManyToOne(targetEntity="BonPlanBundle\Entity\Etablissement")
     *   @ORM\JoinColumn(name="id_etablissement", referencedColumnName="id_etablissement")
     */
    private $idEtablissement;


    /**
     * @var int
     *
     * @ORM\Column(name="note_exp", type="integer", nullable=false)
     */
    private $noteExp;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @return int
     */
    public function getIdExp()
    {
        return $this->idExp;
    }

    /**
     * @param int $idExp
     */
    public function setIdExp($idExp)
    {
        $this->idExp = $idExp;
    }

    /**
     * @return string
     */
    public function getDescriptionExperience()
    {
        return $this->descriptionExperience;
    }

    /**
     * @param string $descriptionExperience
     */
    public function setDescriptionExperience($descriptionExperience)
    {
        $this->descriptionExperience = $descriptionExperience;
    }

    /**
     * @return string
     */
    public function getPreuve()
    {
        return $this->preuve;
    }

    /**
     * @param string $preuve
     */
    public function setPreuve($preuve)
    {
        $this->preuve = $preuve;
    }

    /**
     * @return \DateTime
     */
    public function getDateExp()
    {
        return $this->dateExp;
    }

    /**
     * @param \DateTime $dateExp
     */
    public function setDateExp($dateExp)
    {
        $this->dateExp = $dateExp;
    }

    /**
     * @return BonPlanBundle\Entity\User
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param BonPlanBundle\Entity\User $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return BonPlanBundle\Entity\Etablissement
     */
    public function getIdEtablissement()
    {
        return $this->idEtablissement;
    }

    /**
     * @param BonPlanBundle\Entity\Etablissement $idEtablissement
     */
    public function setIdEtablissement($idEtablissement)
    {
        $this->idEtablissement = $idEtablissement;
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
//
//    /**
//     * @var \Doctrine\Common\Collections\Collection
//     *
//     * @ORM\ManyToMany(targetEntity="CritereEvaluation", inversedBy="idExp")
//     * @ORM\JoinTable(name="evaluation",
//     *   joinColumns={
//     *     @ORM\JoinColumn(name="id_exp", referencedColumnName="id_exp")
//     *   },
//     *   inverseJoinColumns={
//     *     @ORM\JoinColumn(name="id_critere", referencedColumnName="id_critere")
//     *   }
//     * )
//     */
//    private $idCritere;
//
//    /**
//     * Constructor
//     */
//    public function __construct()
//    {
//        $this->idCritere = new \Doctrine\Common\Collections\ArrayCollection();
//    }




    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return int
     */
    public function getNoteExp()
    {
        return $this->noteExp;
    }

    /**
     * @param int $noteExp
     */
    public function setNoteExp($noteExp)
    {
        $this->noteExp = $noteExp;
    }


}
