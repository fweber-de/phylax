<?php

namespace DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Heartbeat.
 *
 * @ORM\Table("heartbeat")
 * @ORM\Entity(repositoryClass="DataBundle\Entity\HeartbeatRepository")
 */
class Heartbeat
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
     * @ORM\Column(name="ip", type="string", length=255)
     */
    private $ip;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_ping", type="datetime")
     */
    private $lastPing;

    /**
     * @ORM\ManyToOne(targetEntity="Application", inversedBy="heartbeats")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id")
     */
    private $application;

    /**
     * @var bool
     *
     * @ORM\Column(name="monitor", type="boolean")
     */
    private $monitor;

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=255, nullable=true)
     */
    private $alias;

    /**
     * @var bool
     *
     * @ORM\Column(name="notified", type="boolean")
     */
    private $notified;

    /**
     * @ORM\OneToMany(targetEntity="Incident", mappedBy="heartbeat")
     */
    private $incidents;

    public function __construct()
    {
        $this->monitor = false;
        $this->incidents = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ip.
     *
     * @param string $ip
     *
     * @return Heartbeat
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip.
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set lastPing.
     *
     * @param \DateTime $lastPing
     *
     * @return Heartbeat
     */
    public function setLastPing($lastPing)
    {
        $this->lastPing = $lastPing;

        return $this;
    }

    /**
     * Get lastPing.
     *
     * @return \DateTime
     */
    public function getLastPing()
    {
        return $this->lastPing;
    }

    /**
     * Set monitor.
     *
     * @param bool $monitor
     *
     * @return Heartbeat
     */
    public function setMonitor($monitor)
    {
        $this->monitor = $monitor;

        return $this;
    }

    /**
     * Get monitor.
     *
     * @return bool
     */
    public function getMonitor()
    {
        return $this->monitor;
    }

    /**
     * Set alias.
     *
     * @param string $alias
     *
     * @return Heartbeat
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias.
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set notified.
     *
     * @param bool $notified
     *
     * @return Heartbeat
     */
    public function setNotified($notified)
    {
        $this->notified = $notified;

        return $this;
    }

    /**
     * Get notified.
     *
     * @return bool
     */
    public function getNotified()
    {
        return $this->notified;
    }

    /**
     * Set application.
     *
     * @param \DataBundle\Entity\Application $application
     *
     * @return Heartbeat
     */
    public function setApplication(\DataBundle\Entity\Application $application = null)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application.
     *
     * @return \DataBundle\Entity\Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Add incident.
     *
     * @param \DataBundle\Entity\Incident $incident
     *
     * @return Heartbeat
     */
    public function addIncident(\DataBundle\Entity\Incident $incident)
    {
        $this->incidents[] = $incident;

        return $this;
    }

    /**
     * Remove incident.
     *
     * @param \DataBundle\Entity\Incident $incident
     */
    public function removeIncident(\DataBundle\Entity\Incident $incident)
    {
        $this->incidents->removeElement($incident);
    }

    /**
     * Get incidents.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIncidents()
    {
        return $this->incidents;
    }
}
