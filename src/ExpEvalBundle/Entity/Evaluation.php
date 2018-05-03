<?php

namespace ExpEvalBundle\Entity;

use BonPlanBundle\Entity\CritereEvaluation;
use Doctrine\ORM\Mapping as ORM;
use BonPlanBundle;
use ExpEvalBundle;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Evaluation
 * @ORM\Entity(repositoryClass="ExpEvalBundle\Repository\EvaluationRepository")
 * @ORM\Table(name="evaluation",indexes={@ORM\Index(name="id_exp", columns={"id_exp"}), @ORM\Index(name="id_critere", columns={"id_critere"})})
 */
class Evaluation
{



    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="ExpEvalBundle\Entity\Experience")
     * @ORM\JoinColumn(name="id_exp", referencedColumnName="id_exp")
     */
    private $idExp;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="BonPlanBundle\Entity\CritereEvaluation")
     * @ORM\JoinColumn(name="id_critere", referencedColumnName="id_critere")
     */
    private $idCritere;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255)
     */
    private $note;



    /**
     * Set idExp
     *
     * @param ExpEvalBundle\Entity\Experience $idExp
     *
     */
    public function setIdExp($idExp)
    {
        $this->idExp = $idExp;

    }

    /**
     * @return Experience
     */
    public function getIdExp()
    {
        return $this->idExp;
    }


    /**
     * Set idCritere
     *
     * @param BonPlanBundle\Entity\CritereEvaluation $idCritere
     *
     */
    public function setIdCritere($idCritere)
    {
        $this->idCritere = $idCritere;
    }

    /**
     * Get idCritere
     *
     * @return BonPlanBundle\Entity\CritereEvaluation
     */
    public function getIdCritere()
    {
        return $this->idCritere;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Evaluation
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }


}

