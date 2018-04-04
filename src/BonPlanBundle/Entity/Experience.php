<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BonPlanBundle;
/**
 * Experience
 *
 * @ORM\Table(name="experience", indexes={@ORM\Index(name="id_etablissement", columns={"id_etablissement"}), @ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
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
     * @ORM\Column(name="description_experience", type="string", length=1200, nullable=false)
     */
    private $descriptionExperience;

    /**
     * @var string
     *
     * @ORM\Column(name="preuve", type="string", length=2000, nullable=false)
     */
    private $preuve;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_exp", type="date", nullable=false)
     */
    private $dateExp;

    /**
     * @var BonPlanBundle\Entity\FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;

    /**
     * @var BonPlanBundle\Entity\Etablissement
     *
     * @ORM\ManyToOne(targetEntity="Etablissement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_etablissement", referencedColumnName="id_etablissement")
     * })
     */
    private $idEtablissement;
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

}

