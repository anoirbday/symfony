<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use yassineBundle;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Offreproduit
 *
 * @ORM\Table(name="offreproduit", indexes={@ORM\Index(name="id_offre", columns={"id_offre"}), @ORM\Index(name="id_produit", columns={"id_produit"})})
 * @ORM\Entity
 */
class Offreproduit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_op", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOp;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_produit", referencedColumnName="id_produit")
     * })
     */
    private $idProduit;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Offre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_offre", referencedColumnName="id_offre")
     * })
     */
    private $idOffre;

    /**
     * @return int
     */
    public function getIdOp()
    {
        return $this->idOp;
    }

    /**
     * @param int $idOp
     */
    public function setIdOp($idOp)
    {
        $this->idOp = $idOp;
    }

    /**
     * @return int
     */
    public function getIdProduit()
    {
        return $this->idProduit;
    }

    /**
     * @param Produit int
     */
    public function setIdProduit($idProduit)
    {
        $this->idProduit = $idProduit;
    }

    /**
     * @return int
     */
    public function getIdOffre()
    {
        return $this->idOffre;
    }

    /**
     * @param Offre int
     */
    public function setIdOffre($idOffre)
    {
        $this->idOffre = $idOffre;
    }


}

