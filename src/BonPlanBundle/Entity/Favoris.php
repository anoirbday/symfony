<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BonPlanBundle;
/**
 * Favoris
 *
 * @ORM\Table(name="favoris", uniqueConstraints={@ORM\UniqueConstraint(name="id_etablissement_2", columns={"id_etablissement", "id"})}, indexes={@ORM\Index(name="id_etablissement", columns={"id_etablissement"}), @ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Favoris
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_favoris", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFavoris;

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


}

