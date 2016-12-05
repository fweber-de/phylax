<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Source
 *
 * @ORM\Table(name="source")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SourceRepository")
 */
class Source
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
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="source_key", type="string", length=255, unique=true)
     */
    private $sourceKey;

    /**
     * @var string
     *
     * @ORM\Column(name="source_secret", type="string", length=255)
     */
    private $sourceSecret;

    /**
     * @ORM\OneToMany(targetEntity="Incident", mappedBy="source")
     */
    private $incidents;

    public function __construct()
    {
        $this->incidents = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Source
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Source
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set sourceKey
     *
     * @param string $sourceKey
     *
     * @return Source
     */
    public function setSourceKey($sourceKey)
    {
        $this->sourceKey = $sourceKey;

        return $this;
    }

    /**
     * Get sourceKey
     *
     * @return string
     */
    public function getSourceKey()
    {
        return $this->sourceKey;
    }

    /**
     * Set sourceSecret
     *
     * @param string $sourceSecret
     *
     * @return Source
     */
    public function setSourceSecret($sourceSecret)
    {
        $this->sourceSecret = $sourceSecret;

        return $this;
    }

    /**
     * Get sourceSecret
     *
     * @return string
     */
    public function getSourceSecret()
    {
        return $this->sourceSecret;
    }

    /**
     * Add incident
     *
     * @param \AppBundle\Entity\Incident $incident
     *
     * @return Source
     */
    public function addIncident(\AppBundle\Entity\Incident $incident)
    {
        $this->incidents[] = $incident;

        return $this;
    }

    /**
     * Remove incident
     *
     * @param \AppBundle\Entity\Incident $incident
     */
    public function removeIncident(\AppBundle\Entity\Incident $incident)
    {
        $this->incidents->removeElement($incident);
    }

    /**
     * Get incidents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIncidents()
    {
        return $this->incidents;
    }
}
