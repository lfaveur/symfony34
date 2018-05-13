<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Biographie")
 */
class Biographie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @ORM\OneToOne(
     *     targetEntity="AppBundle\Entity\Auteur"
     * )
     * @ORM\JoinColumn(
     *     name="mon_auteur",
     *     referencedColumnName="id",
     *     unique=true
     * )
     */
    private $auteur;

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Biographie
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * @param Auteur $auteur
     */
    public function setAuteur(Auteur $auteur)
    {
        $this->auteur = $auteur;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}