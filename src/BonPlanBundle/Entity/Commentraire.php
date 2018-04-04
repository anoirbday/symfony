<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BonPlanBundle;
/**
 * Commentraire
 *
 * @ORM\Table(name="commentraire", indexes={@ORM\Index(name="id_exp", columns={"id_exp"}), @ORM\Index(name="id_ucomm", columns={"id_ucomm"})})
 * @ORM\Entity
 */
class Commentraire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_commentaire", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommentaire;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=3000, nullable=false)
     */
    private $commentaire;

    /**
     * @var BonPlanBundle\Entity\FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ucomm", referencedColumnName="id")
     * })
     */
    private $idUcomm;

    /**
     * @var BonPlanBundle\Entity\Experience
     *
     * @ORM\ManyToOne(targetEntity="Experience")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_exp", referencedColumnName="id_exp")
     * })
     */
    private $idExp;


}

