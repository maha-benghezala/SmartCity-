<?php

namespace questionnaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * historique
 *
 * @ORM\Table(name="historique")
 * @ORM\Entity(repositoryClass="questionnaireBundle\Repository\historiqueRepository")
 */
class historique
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="datetime")
     */
    private $dateFin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="datetime")
     */
    private $dateDebut;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
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
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return historique
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return historique
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return historique
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
     * @return mixed
     */
    public function getProbleme ()
    {
        return $this->Probleme;
    }

    /**
     * @param mixed $Probleme
     */
    public function setProbleme ($Probleme)
    {
        $this->Probleme = $Probleme;
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

