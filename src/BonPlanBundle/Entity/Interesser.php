<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BonPlanBundle;
/**
 * Interesser
 *
 * @ORM\Table(name="interesser", indexes={@ORM\Index(name="id_evenement", columns={"id_evenement"}), @ORM\Index(name="id", columns={"id"})})
 *@ORM\Entity(repositoryClass="BonPlanBundle\Repository\InteresserRepository")
 */
class Interesser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_interesser", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idInteresser;

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
     *
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_evenement", referencedColumnName="id_evenement")
     * })
     */
    private $idEvenement;

    /**
     * @return int
     */
    public function getIdInteresser()
    {
        return $this->idInteresser;
    }

    /**
     * @param int $idInteresser
     */
    public function setIdInteresser($idInteresser)
    {
        $this->idInteresser = $idInteresser;
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
     * @return mixed
     */
    public function getIdEvenement()
    {
        return $this->idEvenement;
    }

    /**
     * @param mixed $idEvenement
     */
    public function setIdEvenement($idEvenement)
    {
        $this->idEvenement = $idEvenement;
    }


}

