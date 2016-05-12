<?php

namespace Ligneus\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Incident.
 *
 * @ORM\Table("incident")
 * @ORM\Entity(repositoryClass="Ligneus\DataBundle\Entity\IncidentRepository")
 */
class Incident
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
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=true)
     */
    private $text;

    /**
     * @var int
     *
     * @ORM\Column(name="status_code", type="integer")
     */
    private $statusCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="occurrence", type="datetime")
     */
    private $occurrence;

    /**
     * @ORM\ManyToOne(targetEntity="Application", inversedBy="incidents")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id")
     */
    private $application;

    /**
     * @var string
     *
     * @ORM\Column(name="trace", type="text", nullable=true)
     */
    private $trace;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=255, nullable=true)
     */
    private $class;

    /**
     * @var string
     *
     * @ORM\Column(name="uri", type="string", length=255, nullable=true)
     */
    private $uri;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255, nullable=true)
     */
    private $ip;

    /**
     * @ORM\ManyToOne(targetEntity="Heartbeat", inversedBy="incidents")
     * @ORM\JoinColumn(name="heartbeat_id", referencedColumnName="id")
     */
    private $heartbeat;

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
     * Set title.
     *
     * @param string $title
     *
     * @return Incident
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set text.
     *
     * @param string $text
     *
     * @return Incident
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set statusCode.
     *
     * @param int $statusCode
     *
     * @return Incident
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Get statusCode.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set occurrence.
     *
     * @param \DateTime $occurrence
     *
     * @return Incident
     */
    public function setOccurrence($occurrence)
    {
        $this->occurrence = $occurrence;

        return $this;
    }

    /**
     * Get occurrence.
     *
     * @return \DateTime
     */
    public function getOccurrence()
    {
        return $this->occurrence;
    }

    /**
     * Set trace.
     *
     * @param string $trace
     *
     * @return Incident
     */
    public function setTrace($trace)
    {
        $this->trace = $trace;

        return $this;
    }

    /**
     * Get trace.
     *
     * @return string
     */
    public function getTrace()
    {
        return $this->trace;
    }

    /**
     * Set message.
     *
     * @param string $message
     *
     * @return Incident
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set class.
     *
     * @param string $class
     *
     * @return Incident
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set uri.
     *
     * @param string $uri
     *
     * @return Incident
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Get uri.
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set ip.
     *
     * @param string $ip
     *
     * @return Incident
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
     * Set application.
     *
     * @param \Ligneus\DataBundle\Entity\Application $application
     *
     * @return Incident
     */
    public function setApplication(\Ligneus\DataBundle\Entity\Application $application = null)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application.
     *
     * @return \Ligneus\DataBundle\Entity\Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Set heartbeat.
     *
     * @param \Ligneus\DataBundle\Entity\Heartbeat $heartbeat
     *
     * @return Incident
     */
    public function setHeartbeat(\Ligneus\DataBundle\Entity\Heartbeat $heartbeat = null)
    {
        $this->heartbeat = $heartbeat;

        return $this;
    }

    /**
     * Get heartbeat.
     *
     * @return \Ligneus\DataBundle\Entity\Heartbeat
     */
    public function getHeartbeat()
    {
        return $this->heartbeat;
    }
}
