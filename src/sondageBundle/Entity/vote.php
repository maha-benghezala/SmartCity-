<?php

namespace sondageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * vote
 *
 * @ORM\Table(name="vote")
 * @ORM\Entity(repositoryClass="sondageBundle\Repository\voteRepository")
 */
class vote
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
     * @ORM\Column(name="suggerer", type="string", length=255)
     */
    private $suggerer;

    /**
     * @var bool
     *
     * @ORM\Column(name="vote", type="boolean")
     */
    private $vote;
    /**
     * @ORM\ManyToOne(targetEntity="questionnaireBundle\Entity\Suggestion")
     * @ORM\JoinColumn(name="suggestion_id",referencedColumnName="id")
     */
    private $suggestion;
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
     * @return string
     */
    public function getSuggerer ()
    {
        return $this->suggerer;
    }

    /**
     * @param string $suggerer
     */
    public function setSuggerer ($suggerer)
    {
        $this->suggerer = $suggerer;
    }


    /**
     * Set vote
     *
     * @param boolean $vote
     *
     * @return vote
     */
    public function setVote($vote)
    {
        $this->vote = $vote;

        return $this;
    }

    /**
     * Get vote
     *
     * @return bool
     */
    public function getVote()
    {
        return $this->vote;
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

    /**
     * @return mixed
     */
    public function getSuggestion()
    {
        return $this->suggestion;
    }

    /**
     * @param mixed $suggestion
     */
    public function setSuggestion($suggestion)
    {
        $this->suggestion = $suggestion;
    }

}

