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
}
