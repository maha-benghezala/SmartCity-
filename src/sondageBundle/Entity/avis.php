<?php

namespace sondageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * avis
 *
 * @ORM\Table(name="avis")
 * @ORM\Entity(repositoryClass="sondageBundle\Repository\avisRepository")
 */
class avis
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
     * @ORM\Column(name="choix", type="string", length=255)
     */
    private $choix;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", length=255)
     */
    private $date;
    /**
     * @ORM\ManyToOne(targetEntity="questionnaireBundle\Entity\question")
     * @ORM\JoinColumn(name="question_id",referencedColumnName="id")
     */
    private $idQuestion;

    /**
     * @ORM\ManyToOne(targetEntity="testBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $idUser;


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
     * Set choix
     *
     * @param string $choix
     *
     * @return avis
     */
    public function setChoix($choix)
    {
        $this->choix = $choix;

        return $this;
    }

    /**
     * Get choix
     *
     * @return string
     */
    public function getChoix()
    {
        return $this->choix;
    }

    /**
     * @return \DateTime
     */
    public function getDate ()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate ($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getIdQuestion ()
    {
        return $this->idQuestion;
    }

    /**
     * @param mixed $idQuestion
     */
    public function setIdQuestion ($idQuestion)
    {
        $this->idQuestion = $idQuestion;
    }

    /**
     * @return mixed
     */
    public function getIdUser ()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser ($idUser)
    {
        $this->idUser = $idUser;
    }
}

