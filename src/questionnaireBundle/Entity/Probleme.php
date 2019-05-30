<?php

namespace questionnaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Probleme
 *
 * @ORM\Table(name="probleme")
 * @ORM\Entity(repositoryClass="questionnaireBundle\Repository\ProblemeRepository")
 */
class Probleme
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="string", length=255, nullable=true)
     */
    private $video;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="testBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $idUser;
    /**
     * @ORM\ManyToOne(targetEntity="testBundle\Entity\User")
     * @ORM\JoinColumn(name="municipalite_id",referencedColumnName="id")
     */
    private $idMunicipalite;
    /**
     * @var int
     *
     * @ORM\Column(name="nbsignale", type="integer")
     */
    private $nbsignale;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var bool
     *
     * @ORM\Column(name="statut", type="boolean")
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255, nullable=true)
     */
    private $longitude;


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
     * Set titre
     *
     * @param string $titre
     *
     * @return Probleme
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
     * Set description
     *
     * @param string $description
     *
     * @return Probleme
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
     * Set image
     *
     * @param string $image
     *
     * @return Probleme
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set video
     *
     * @param string $video
     *
     * @return Probleme
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Probleme
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }



    /**
     * Set nbsignale
     *
     * @param integer $nbsignale
     *
     * @return Probleme
     */
    public function setNbsignale($nbsignale)
    {
        $this->nbsignale = $nbsignale;

        return $this;
    }

    /**
     * Get nbsignale
     *
     * @return int
     */
    public function getNbsignale()
    {
        return $this->nbsignale;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Probleme
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Probleme
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Probleme
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return bool
     */
    public function isStatut ()
    {
        return $this->statut;
    }

    /**
     * @param bool $statut
     */
    public function setStatut ($statut)
    {
        $this->statut = $statut;
    }

    /**
     * @return mixed
     */
    public function getIdMunicipalite ()
    {
        return $this->idMunicipalite;
    }

    /**
     * @param mixed $idMunicipalite
     */
    public function setIdMunicipalite ($idMunicipalite)
    {
        $this->idMunicipalite = $idMunicipalite;
    }

}

