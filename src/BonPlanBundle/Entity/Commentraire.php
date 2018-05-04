<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BonPlanBundle;
/**
 * Commentraire
 *
 * @ORM\Table(name="commentraire", indexes={@ORM\Index(name="id_exp", columns={"id_exp"}), @ORM\Index(name="id_ucomm", columns={"id_ucomm"})})
 * @ORM\Entity(repositoryClass="BonPlanBundle\Repository\CommentaireRepository")
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
     * @var BonPlanBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User")
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

    /**
     * @return int
     */
    public function getIdCommentaire()
    {
        return $this->idCommentaire;
    }

    /**
     * @param int $idCommentaire
     */
    public function setIdCommentaire($idCommentaire)
    {
        $this->idCommentaire = $idCommentaire;
    }

    /**
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param string $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * @return User
     */
    public function getIdUcomm()
    {
        return $this->idUcomm;
    }

    /**
     * @param User $idUcomm
     */
    public function setIdUcomm($idUcomm)
    {
        $this->idUcomm = $idUcomm;
    }

    /**
     * @return Experience
     */
    public function getIdExp()
    {
        return $this->idExp;
    }

    /**
     * @param Experience $idExp
     */
    public function setIdExp($idExp)
    {
        $this->idExp = $idExp;
    }


}

