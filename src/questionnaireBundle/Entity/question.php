<?php

namespace questionnaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="questionnaireBundle\Repository\questionRepository")
 */
class question
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
     * @ORM\Column(name="question", type="string", length=255,nullable=true)
     */
    private $question;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    /**
     * @var string
     *
     * @ORM\Column(name="choix1", type="string", length=255,nullable=true)
     */
    private $choix1;
    /**
     * @var string
     *
     * @ORM\Column(name="choix2", type="string", length=255,nullable=true)
     */
    private $choix2;
    /**
     * @var string
     *
     * @ORM\Column(name="choix3", type="string", length=255,nullable=true)
     */
    private $choix3;
    /**
     * @var string
     *
     * @ORM\Column(name="choix4", type="string", length=255,nullable=true)
     */
    private $choix4;
    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255,nullable=true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255,nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="testBundle\Entity\User")
     * @ORM\JoinColumn(name="municipalite_id",referencedColumnName="id")
     */
    private $idMunicipalite;

    /**
     * @return int
     */
    public function getId ()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getQuestion ()
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion ($question)
    {
        $this->question = $question;
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
     * @return string
     */
    public function getDescription ()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription ($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDate ()
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate ($date)
    {
        $this->date = $date;
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

    /**
     * @return string
     */
    public function getChoix1 ()
    {
        return $this->choix1;
    }

    /**
     * @param string $choix1
     */
    public function setChoix1 ($choix1)
    {
        $this->choix1 = $choix1;
    }

    /**
     * @return string
     */
    public function getChoix2 ()
    {
        return $this->choix2;
    }

    /**
     * @param string $choix2
     */
    public function setChoix2 ($choix2)
    {
        $this->choix2 = $choix2;
    }

    /**
     * @return string
     */
    public function getChoix3 ()
    {
        return $this->choix3;
    }

    /**
     * @param string $choix3
     */
    public function setChoix3 ($choix3)
    {
        $this->choix3 = $choix3;
    }

    /**
     * @return string
     */
    public function getChoix4 ()
    {
        return $this->choix4;
    }

    /**
     * @param string $choix4
     */
    public function setChoix4 ($choix4)
    {
        $this->choix4 = $choix4;
    }


}

