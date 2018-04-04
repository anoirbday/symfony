<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BonPlanBundle;
/**
 * CritereEvaluation
 *
 * @ORM\Table(name="critere_evaluation", indexes={@ORM\Index(name="id_categorie", columns={"id_categorie"})})
 * @ORM\Entity
 */
class CritereEvaluation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_critere", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCritere;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_critere_evaluation", type="string", length=200, nullable=false)
     */
    private $nomCritereEvaluation;

    /**
     * @var BonPlanBundle\Entity\Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie", referencedColumnName="id_categorie")
     * })
     */
    private $idCategorie;

//    /**
//     * @var \Doctrine\Common\Collections\Collection
//     *
//     * @ORM\ManyToMany(targetEntity="Experience", mappedBy="idCritere")
//     */
//    private $idExp;
//
//    /**
//     * Constructor
//     */
//    public function __construct()
//    {
//        $this->idExp = new \Doctrine\Common\Collections\ArrayCollection();
//    }

}

