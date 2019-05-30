<?php

namespace questionnaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abonnement
 *
 * @ORM\Table(name="abonnement")
 * @ORM\Entity(repositoryClass="questionnaireBundle\Repository\AbonnementRepository")
 */
class Abonnement
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
     * @ORM\ManyToOne(targetEntity="testBundle\Entity\User")
     * @ORM\JoinColumn(name="id_municipalite",referencedColumnName="id")
     */
    private $idMunicipalite;

    /**
     * @ORM\ManyToOne(targetEntity="testBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id")
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

}

