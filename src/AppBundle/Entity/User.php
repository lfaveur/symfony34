<?php

class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    // ... Autres attributs : nom / prénom ...

    /**
     * @var Diplome
     *
     * @ORM\OneToMany(targetEntity="Diplome", mappedBy="user", cascade="all", orphanRemoval=true)
     * @Assert\Valid()
     * @OrderBy({"position" = "ASC"})
     */
    private $diplomes;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->diplomes = new ArrayCollection();
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

    // ... Autres getter et setter

    /**
     * Add diplome
     *
     * @param Diplome $diplome
     *
     * @return User
     */
    public function addDiplome(Diplome $diplome)
    {
        $this->diplomes[] = $diplome;
        $diplome->setUser($this);

        return $this;
    }

    /**
     * Remove diplome
     *
     * @param Diplome $diplome
     */
    public function removeDiplome(Diplome $diplome)
    {
        $this->diplomes->removeElement($diplome);
    }

    /**
     * Get diplomes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDiplomes()
    {
        return $this->diplomes;
    }
}