<?php

namespace Casecenter\PlanningBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Package
 *
 * @ORM\Table(name="packages")
 * @ORM\Entity(repositoryClass="Casecenter\PlanningBundle\Entity\PackageRepository")
 * @UniqueEntity(fields={"slug"}, message="This slug is already used.")
 * @Gedmo\SoftDeleteable(fieldName="archive", timeAware=false)
 */
class Package
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Casecenter\PlanningBundle\Entity\Planning", inversedBy="packages")
     * @ORM\JoinColumn(name="planning_id", referencedColumnName="id", nullable=false)
     */
    private $planning;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message="Please enter a name.")
     */
    private $name;

    /**
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(name="vignette", type="string", length=255, nullable=true)
     * @Assert\Url(message="This vignette is not a valid URL.")
     */
    private $vignette;

    /**
     * @ORM\OneToMany(targetEntity="Casecenter\PlanningBundle\Entity\Booking", mappedBy="package")
     */
    private $bookings;

    /**
     * @ORM\Column(name="archive", type="datetime", nullable=true)
     */
    private $archive;

    public function __construct() {
        $this->enabled = TRUE;
        $this->bookings = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * id
     */
    public function getId() {return $this->id;}

    /**
     * planning
     */
    public function setPlanning(\Casecenter\PlanningBundle\Entity\Planning $planning) {
        $this->planning = $planning;
        return $this;
    }
    public function getPlanning() {return $this->planning;}

    /**
     * name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    public function getName() {return $this->name;}

    /**
     * slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }
    public function getSlug() {return $this->slug;}

    /**
     * enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }
    public function getEnabled() {return $this->enabled;}

    /**
     * vignette
     */
    public function setVignette($vignette)
    {
        $this->vignette = $vignette;
        return $this;
    }
    public function getVignette() {return $this->vignette;}
    
    /**
     * Booking
     */
    public function getBookings() {return $this->bookings;}

    /**
     * archive
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;
        return $this;
    }
    public function getArchive() {return $this->archive;}
}
