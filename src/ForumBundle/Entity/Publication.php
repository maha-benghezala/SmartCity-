<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table(name="publication")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\PublicationRepository")
 */
class Publication
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
     * @ORM\ManyToOne(targetEntity="questionnaireBundle\Entity\Probleme")
     * @ORM\JoinColumn(name="id_probleme" , referencedColumnName="id")
     */
    private $idProbleme;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="questionnaireBundle\Entity\Suggestion")
     * @ORM\JoinColumn(name="id_suggestion" , referencedColumnName="id")
     */
    private $idSuggestion;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetimetz")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="nbrlike", type="string", length=255)
     */
    private $nbrlike;


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
     * Set idProbleme
     *
     * @param string $idProbleme
     *
     * @return Publication
     */
    public function setIdProbleme($idProbleme)
    {
        $this->idProbleme = $idProbleme;

        return $this;
    }

    /**
     * Get idProbleme
     *
     * @return string
     */
    public function getIdProbleme()
    {
        return $this->idProbleme;
    }

    /**
     * Set idSuggestion
     *
     * @param string $idSuggestion
     *
     * @return Publication
     */
    public function setIdSuggestion($idSuggestion)
    {
        $this->idSuggestion = $idSuggestion;

        return $this;
    }

    /**
     * Get idSuggestion
     *
     * @return string
     */
    public function getIdSuggestion()
    {
        return $this->idSuggestion;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Publication
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Publication
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
     * Set nbrlike
     *
     * @param string $nbrlike
     *
     * @return Publication
     */
    public function setNbrlike($nbrlike)
    {
        $this->nbrlike = $nbrlike;

        return $this;
    }

    /**
     * Get nbrlike
     *
     * @return string
     */
    public function getNbrlike()
    {
        return $this->nbrlike;
    }
}

