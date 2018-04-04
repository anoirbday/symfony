<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BonPlanBundle;
/**
 * Offre
 *
 * @ORM\Table(name="offre", indexes={@ORM\Index(name="id_etablissement", columns={"id_etablissement"})})
 * @ORM\Entity
 */
class Offre
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_offre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOffre;

    /**
     * @var string
     *
     * @ORM\Column(name="titre_offre", type="string", length=100, nullable=false)
     */
    private $titreOffre;

    /**
     * @var string
     *
     * @ORM\Column(name="description_offre", type="text", nullable=false)
     */
    private $descriptionOffre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_offre", type="string", length=2000, nullable=false)
     */
    private $photoOffre;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombre_like", type="integer", nullable=true)
     */
    private $nombreLike;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombre_dislike", type="integer", nullable=true)
     */
    private $nombreDislike;

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

