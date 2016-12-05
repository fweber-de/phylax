<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceRepository")
 */
class Service
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
     * @ORM\Column(name="defined_name", type="string", length=255)
     */
    private $definedName;

    /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="services")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     */
    private $team;

    private $availableServices;

    public function __construct($serviceName, $team)
    {
        $this->availableServices = [
            'slack',
            'mail'
        ];

        if(!in_array($serviceName, $this->availableServices)) {
            throw new \Exception(sprintf('%s is not an available service!', $serviceName));
        }

        $this->definedName = $serviceName;
        $this->team = $team;
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
     * Set definedName
     *
     * @param string $definedName
     *
     * @return Service
     */
    public function setDefinedName($definedName)
    {
        if(!in_array($definedName, $this->availableServices)) {
            throw new \Exception(sprintf('%s is not an available service!', $definedName));
        }

        $this->definedName = $definedName;

        return $this;
    }

    /**
     * Get definedName
     *
     * @return string
     */
    public function getDefinedName()
    {
        return $this->definedName;
    }

    /**
     * Set team
     *
     * @param \AppBundle\Entity\Team $team
     *
     * @return Service
     */
    public function setTeam(\AppBundle\Entity\Team $team = null)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \AppBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
    }
}
