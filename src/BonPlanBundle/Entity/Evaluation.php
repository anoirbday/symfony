<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BonPlanBundle;
/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation")
 * @ORM\Entity(repositoryClass="BonPlanBundle\Repository\EvaluationRepository")
 */
class Evaluation
{
    /**
     * @var BonPlanBundle\Entity\Experience
     *
     * @ORM\Column(name="id_exp", type="integer")
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Experience")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_exp", referencedColumnName="id_exp")
     * })
     */
    private $idExp;

    /**
     * @var BonPlanBundle\Entity\CritereEvaluation
     *
     * @ORM\Column(name="id_critere", type="integer")
     * @ORM\Id
     * @ORM\OneToMany(targetEntity="CritereEvaluation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_critere", referencedColumnName="id_critere")
     * })
     */
    private $idCritere;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255)
     */
    private $note;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idExp
     *
     * @param integer $idExp
     *
     * @return Evaluation
     */
    public function setIdExp($idExp)
    {
        $this->idExp = $idExp;

        return $this;
    }

    /**
     * Get idExp
     *
     * @return int
     */
    public function getIdExp()
    {
        return $this->idExp;
    }

    /**
     * Set idCritere
     *
     * @param integer $idCritere
     *
     * @return Evaluation
     */
    public function setIdCritere($idCritere)
    {
        $this->idCritere = $idCritere;

        return $this;
    }

    /**
     * Get idCritere
     *
     * @return int
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

