<?php

namespace DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;

/**
 * Application.
 *
 * @ORM\Table("application")
 * @ORM\Entity
 *
 * @ExclusionPolicy("none")
 */
class Application
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="appkey", type="string", length=255, unique=true)
     */
    private $appkey;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="Incident", mappedBy="application")
     *
     * @Exclude
     */
    private $incidents;

    /**
     * @var string
     *
     * @ORM\Column(name="color_hex", type="string", length=255)
     */
    private $colorHex;

    /**
     * @var bool
     *
     * @ORM\Column(name="send_email", type="boolean")
     */
    private $sendEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="email_recipients", type="string", length=255)
     */
    private $emailRecipients;

    /**
     * @ORM\OneToMany(targetEntity="Heartbeat", mappedBy="application")
     *
     * @Exclude
     */
    private $heartbeats;

    /**
     * @var bool
     *
     * @ORM\Column(name="send_slack", type="boolean")
     */
    private $sendSlack;

    /**
     * @var string
     *
     * @ORM\Column(name="slack_url", type="string", length=255)
     */
    private $slackUrl;

    public function __construct()
    {
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
     * Set name.
     *
     * @param string $name
     *
     * @return Application
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set appkey.
     *
     * @param string $appkey
     *
     * @return Application
     */
    public function setAppkey($appkey)
    {
        $this->appkey = $appkey;

        return $this;
    }

    /**
     * Get appkey.
     *
     * @return string
     */
    public function getAppkey()
    {
        return $this->appkey;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return Application
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set colorHex.
     *
     * @param string $colorHex
     *
     * @return Application
     */
    public function setColorHex($colorHex)
    {
        $this->colorHex = $colorHex;

        return $this;
    }

    /**
     * Get colorHex.
     *
     * @return string
     */
    public function getColorHex()
    {
        return $this->colorHex;
    }

    /**
     * Set sendEmail.
     *
     * @param bool $sendEmail
     *
     * @return Application
     */
    public function setSendEmail($sendEmail)
    {
        $this->sendEmail = $sendEmail;

        return $this;
    }

    /**
     * Get sendEmail.
     *
     * @return bool
     */
    public function getSendEmail()
    {
        return $this->sendEmail;
    }

    /**
     * Set emailRecipients.
     *
     * @param string $emailRecipients
     *
     * @return Application
     */
    public function setEmailRecipients($emailRecipients)
    {
        $this->emailRecipients = $emailRecipients;

        return $this;
    }

    /**
     * Get emailRecipients.
     *
     * @return string
     */
    public function getEmailRecipients()
    {
        return $this->emailRecipients;
    }

    /**
     * Set sendSlack.
     *
     * @param bool $sendSlack
     *
     * @return Application
     */
    public function setSendSlack($sendSlack)
    {
        $this->sendSlack = $sendSlack;

        return $this;
    }

    /**
     * Get sendSlack.
     *
     * @return bool
     */
    public function getSendSlack()
    {
        return $this->sendSlack;
    }

    /**
     * Set slackUrl.
     *
     * @param string $slackUrl
     *
     * @return Application
     */
    public function setSlackUrl($slackUrl)
    {
        $this->slackUrl = $slackUrl;

        return $this;
    }

    /**
     * Get slackUrl.
     *
     * @return string
     */
    public function getSlackUrl()
    {
        return $this->slackUrl;
    }

    /**
     * Add incident.
     *
     * @param \DataBundle\Entity\Incident $incident
     *
     * @return Application
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

    /**
     * Add heartbeat.
     *
     * @param \DataBundle\Entity\Heartbeat $heartbeat
     *
     * @return Application
     */
    public function addHeartbeat(\DataBundle\Entity\Heartbeat $heartbeat)
    {
        $this->heartbeats[] = $heartbeat;

        return $this;
    }

    /**
     * Remove heartbeat.
     *
     * @param \\DataBundle\Entity\Heartbeat $heartbeat
     */
    public function removeHeartbeat(\DataBundle\Entity\Heartbeat $heartbeat)
    {
        $this->heartbeats->removeElement($heartbeat);
    }

    /**
     * Get heartbeats.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHeartbeats()
    {
        return $this->heartbeats;
    }
}
