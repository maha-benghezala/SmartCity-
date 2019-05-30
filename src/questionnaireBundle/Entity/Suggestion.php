<?php

namespace questionnaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Suggestion
 *
 * @ORM\Table(name="suggestion")
 * @ORM\Entity(repositoryClass="questionnaireBundle\Repository\SuggestionRepository")
 */
class Suggestion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;
    /**
     * @var string
     *
     * @ORM\Column(name="rapport", type="string", length=255,nullable=true)
     */
    private $rapport;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="date")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="date")
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;
    /**
     * @ORM\ManyToOne(targetEntity="questionnaireBundle\Entity\Probleme")
     * @ORM\JoinColumn(name="probleme_id",referencedColumnName="id")
     */
    private $Probleme;
    /**
     * @ORM\ManyToOne(targetEntity="testBundle\Entity\User")
     * @ORM\JoinColumn(name="id_municipalite",referencedColumnName="id")
     */
    private $idMunicipalite;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Suggestion
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Suggestion
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }



    /**
     * @return mixed
     */
    public function getProbleme()
    {
        return $this->Probleme;
    }

    /**
     * @param mixed $Probleme
     */
    public function setProbleme($Probleme)
    {
        $this->Probleme = $Probleme;
    }



    /**
     * @return string
     */
    public function getTitre ()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre ($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return mixed
     */
    public function getIdMunicipalite()
    {
        return $this->idMunicipalite;
    }

    /**
     * @param mixed $idMunicipalite
     */
    public function setIdMunicipalite($idMunicipalite)
    {
        $this->idMunicipalite = $idMunicipalite;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebut ()
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTime $dateDebut
     */
    public function setDateDebut ($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin ()
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime $dateFin
     */
    public function setDateFin ($dateFin)
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return string
     */
    public function getRapport ()
    {
        return $this->rapport;
    }

    /**
     * @param string $rapport
     */
    public function setRapport ($rapport)
    {
        $this->rapport = $rapport;
    }

}

