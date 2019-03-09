<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Livre")
 */
class Livre
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Theme",cascade={"persist"})
     * @ORM\JoinTable(name="themes_des_livres",
     *     joinColumns={
     *         @ORM\JoinColumn(
     *             name="id_du_livre",
     *             referencedColumnName="id"
     *         )
     *     },
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(
     *             name="theme_id",
     *             referencedColumnName="id"
     *         )
     *     }
     * )
     */
    private $themes;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_parution", type="date", nullable=true)
     */
    private $dateParution;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="Auteur", inversedBy="livres")
     */
    private $auteur;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->themes = new \Doctrine\Common\Collections\ArrayCollection();
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



    /**
     * @param Theme $theme
     * @return Livre
     */
    public function addTheme(Theme $theme)
    {
        $this->themes[] = $theme;

        return $this;
    }

    /**
     * @param mixed $theme
     * @return Livre
     */
    public function removeTheme(Theme $theme)
    {
        $this->themes->removeElement($theme);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getThemes()
    {
        return $this->themes->toArray();
    }
    
    /**
     * Set titre
     *
     * @param string $titre
     * @return Livre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set dateParution
     *
     * @param \DateTime $dateParution
     * @return Livre
     */
    public function setDateParution($dateParution)
    {
        $this->dateParution = $dateParution;

        return $this;
    }

    /**
     * Get dateParution
     *
     * @return \DateTime
     */
    public function getDateParution()
    {
        return $this->dateParution;
    }

    /**
     * Set auteur
     *
     * @param \AppBundle\Entity\Auteur $auteur
     * @return Livre
     */
    public function setAuteur(\AppBundle\Entity\Auteur $auteur = null)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return \AppBundle\Entity\Auteur
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set text.
     *
     * @param string|null $text
     *
     * @return Livre
     */
    public function setText($text = null)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text.
     *
     * @return string|null
     */
    public function getText()
    {
        return $this->text;
    }
}
