<?php

namespace Casecenter\PlanningBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Date
 *
 * @ORM\Table(name="dates")
 * @ORM\Entity(repositoryClass="Casecenter\PlanningBundle\Entity\DateRepository")
 * @Gedmo\SoftDeleteable(fieldName="archive", timeAware=false)
 */
class Date
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\Column(name="events", type="array")
     */
    private $events;

    /**
     * @ORM\Column(name="packs", type="array")
     */
    private $packs;

    /**
     * @ORM\OneToMany(targetEntity="Casecenter\PlanningBundle\Entity\BookingDate", mappedBy="date")
     */
    private $bookings;

    /**
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(name="archive", type="datetime", nullable=true)
     */
    private $archive;

    public function __construct() {
        $this->enabled = TRUE;
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
     * Set date
     *
     * @param \DateTime $date
     * @return Date
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * events 
     */
    public function addEvents($pack) {$this->events[] = $event; return $this;}
    public function removeEvents($pack) {$this->events->removeElement($event);}
    public function getEvents() {return $this->events;}

    /**
     * packs
     */
    public function addPacks($pack) {$this->packs[] = $pack; return $this;}
    public function removePacks($pack) {$this->packs->removeElement($pack);}
    public function getPacks() {return $this->packs;}

    /**
     * bookings
     */
    public function getBookings()
    {
        return $this->bookings;
    }

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
