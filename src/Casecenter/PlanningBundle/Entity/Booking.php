<?php

namespace Casecenter\PlanningBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Booking
 *
 * @ORM\Table(name="bookings")
 * @ORM\Entity(repositoryClass="Casecenter\PlanningBundle\Entity\BookingRepository")
 * @Gedmo\SoftDeleteable(fieldName="archive", timeAware=false)
 */
class Booking
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Casecenter\PlanningBundle\Entity\Package", inversedBy="bookings")
     * @ORM\JoinColumn(name="package_id", referencedColumnName="id", nullable=false)
     */
    private $package;

    /**
     * @ORM\Column(name="advertiser", type="string", length=255)
     */
    private $advertiser;

    /**
     * @ORM\Column(name="campaign", type="string", length=255)
     */
    private $campaign;

    /**
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="Casecenter\PlanningBundle\Entity\BookingDate", mappedBy="booking")
     */
    private $dates;

    /**
     * @ORM\ManyToOne(targetEntity="Casecenter\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     * @Gedmo\Blameable(on="create")
     */
    private $user;

    /**
     * @ORM\Column(name="creation", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $creation;

    /**
     * @ORM\Column(name="archive", type="datetime", nullable=true)
     */
    private $archive;

    public function __construct() {
    }

    /**
     * id 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * package
     */
    public function setPackage(\Casecenter\PlanningBundle\Entity\Package $package) {
        $this->package = $package;
        return $this;
    }
    public function getPackage() {return $this->package;}

    /**
     * Set advertiser
     *
     * @param string $advertiser
     * @return Booking
     */
    public function setAdvertiser($advertiser)
    {
        $this->advertiser = $advertiser;
    
        return $this;
    }

    /**
     * Get advertiser
     *
     * @return string 
     */
    public function getAdvertiser()
    {
        return $this->advertiser;
    }

    /**
     * Set campaign
     *
     * @param string $campaign
     * @return Booking
     */
    public function setCampaign($campaign)
    {
        $this->campaign = $campaign;
    
        return $this;
    }

    /**
     * Get campaign
     *
     * @return string 
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Booking
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * dates
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     *
     */
    public function isValid()
    {
        $valid = FALSE;

        foreach ($this->getDates() as $date) {
            if ($date->isAvailable()) {$valid = TRUE;}
        }

        return $valid;
    }

    /**
     * user
     */
    public function setUser(\Casecenter\UserBundle\Entity\User $user) {
        $this->user = $user;
        return $this;
    }
    public function getUser() {return $this->user;}

    /**
     * creation
     */
    public function setCreation($creation)
    {
        $this->creation = $creation;
    
        return $this;
    }
    public function getCreation()
    {
        return $this->creation;
    }

    /**
     * archive
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;
    
        return $this;
    }
    public function getArchive()
    {
        return $this->archive;
    }
}
