<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BonPlanBundle;
/**
 * Favoris
 *
 * @ORM\Table(name="favoris", uniqueConstraints={@ORM\UniqueConstraint(name="id_etablissement_2", columns={"id_etablissement", "id"})}, indexes={@ORM\Index(name="id_etablissement", columns={"id_etablissement"}), @ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="BonPlanBundle\Repository\FavorisRepository")
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
     * @var BonPlanBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User")
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

    /**
     * @return int
     */
    public function getIdFavoris()
    {
        return $this->idFavoris;
    }

    /**
     * @param int $idFavoris
     */
    public function setIdFavoris($idFavoris)
    {
        $this->idFavoris = $idFavoris;
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
     * @return Etablissement
     */
    public function getIdEtablissement()
    {
        return $this->idEtablissement;
    }

    /**
     * @param Etablissement $idEtablissement
     */
    public function setIdEtablissement($idEtablissement)
    {
        $this->idEtablissement = $idEtablissement;
    }




}

