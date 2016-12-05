<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inicident
 *
 * @ORM\Table(name="inicident")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InicidentRepository")
 */
class Inicident
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
     * @ORM\ManyToOne(targetEntity="Source", inversedBy="incidents")
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id")
     */
    private $source;
}
