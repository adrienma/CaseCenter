<?php

namespace Casecenter\PlanningBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * BookingDate
 *
 * @ORM\Table(name="bookingsdates")
 * @ORM\Entity(repositoryClass="Casecenter\PlanningBundle\Entity\BookingDateRepository")
 * @Gedmo\SoftDeleteable(fieldName="archive", timeAware=false)
 */
class BookingDate
{
	/**
	* @ORM\Id
	* @ORM\ManyToOne(targetEntity="Casecenter\PlanningBundle\Entity\Booking", inversedBy="dates")
	*/
	private $booking;

	/**
	* @ORM\Id
	* @ORM\ManyToOne(targetEntity="Casecenter\PlanningBundle\Entity\Date", inversedBy="bookings")
	*/
	private $date;

	/**
	* @ORM\Column(name="price", type="string")
	*/
	private $price;

    /**
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

	/**
     * @ORM\Column(name="archive", type="datetime", nullable=true)
     */
    private $archive;

    public function __construct() {
        $this->status = "option";
    }

    /**
     * Set price
     *
     * @param string $price
     * @return BookingDate
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
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
     * Set archive
     *
     * @param \DateTime $archive
     * @return BookingDate
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;
    
        return $this;
    }

    /**
     * Get archive
     *
     * @return \DateTime 
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * Set booking
     *
     * @param \Casecenter\PlanningBundle\Entity\Booking $booking
     * @return BookingDate
     */
    public function setBooking(\Casecenter\PlanningBundle\Entity\Booking $booking)
    {
        $this->booking = $booking;
    
        return $this;
    }

    /**
     * Get booking
     *
     * @return \Casecenter\PlanningBundle\Entity\Booking 
     */
    public function getBooking()
    {
        return $this->booking;
    }

    /**
     * Set date
     *
     * @param \Casecenter\PlanningBundle\Entity\Date $date
     * @return BookingDate
     */
    public function setDate(\Casecenter\PlanningBundle\Entity\Date $date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \Casecenter\PlanningBundle\Entity\Date 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     *
     */
    public function isAvailable()
    {
        return $this->getDate()->getEnabled();
    }
}