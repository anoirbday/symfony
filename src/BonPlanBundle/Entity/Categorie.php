<?php

namespace BonPlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie", uniqueConstraints={@ORM\UniqueConstraint(name="nom_categorie", columns={"nom_categorie"})})
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_categorie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_categorie", type="string", length=30, nullable=false)
     */
    private $nomCategorie;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * Categorie constructor.
     * @param int $idCategorie
     * @param string $nomCategorie
     * @param bool $enabled
     */

    /**
     * Get idCategorie
     *
     * @return integer
     */
    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    public function __toString()
    {
        return $this->nomCategorie;
    }


    /**
     * Set nomCategorie
     *
     * @param string $nomCategorie
     *
     * @return Categorie
     */
    public function setNomCategorie($nomCategorie)
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    /**
     * Get nomCategorie
     *
     * @return string
     */
    public function getNomCategorie()
    {
        return $this->nomCategorie;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Categorie
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

}
