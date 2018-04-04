<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BonPlanBundle;
/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="id_etablissement", columns={"id_etablissement"})})
 * @ORM\Entity
 */
class Produit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_produit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_produit", type="string", length=200, nullable=false)
     */
    private $nomProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_produit", type="string", length=2000, nullable=false)
     */
    private $photoProduit;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_produit", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixProduit;

    /**
     * @var BonPlanBundle\Entity\Etablissement
     *
     * @ORM\ManyToOne(targetEntity="Etablissement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_etablissement", referencedColumnName="id_etablissement")
     * })
     */
    private $idEtablissement;


}

