<?php

namespace Casecenter\PlanningBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Planning
 *
 * @ORM\Table(name="plannings")
 * @ORM\Entity(repositoryClass="Casecenter\PlanningBundle\Entity\PlanningRepository")
 * @UniqueEntity(fields={"slug"}, message="This slug is already used.")
 * @Gedmo\SoftDeleteable(fieldName="archive", timeAware=false)
 */
class Planning
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message="Please enter a planning name.")
     */
    private $name;

    /**
     * @ORM\Column(name="name_public", type="string", length=255)
     * @Assert\NotBlank(message="Please enter a planning public name.")
     */
    private $namePublic;

    /**
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     * @Gedmo\Slug(fields={"namePublic"})
     */
    private $slug;

    /**
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(name="scheduleStart", type="datetime")
     * @Assert\DateTime()
     */
    //private $scheduleStart;

    /**
     * @ORM\Column(name="scheduleEnd", type="datetime")
     * @Assert\DateTime()
     */
    //private $scheduleEnd;

    /**
     * @ORM\Column(name="reservationStart", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    //private $reservationStart;

    /**
     * @ORM\Column(name="reservationEnd", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    //private $reservationEnd;

    /**
     * @ORM\Column(name="vignette", type="string", length=255, nullable=true)
     * @Assert\Url(message="This vignette is not a valid URL.")
     */
    private $vignette;

    /**
     * @ORM\OneToMany(targetEntity="Casecenter\PlanningBundle\Entity\Package", mappedBy="planning")
     */
    //private $packages;

    /**
     * @ORM\Column(name="archive", type="datetime", nullable=true)
     */
    private $archive;

    public function __construct() {
        $this->enabled = TRUE;
        //$this->scheduleStart = new \DateTime();
        //$this->scheduleEnd = (new \DateTime())->add(new \DateInterval('P1Y'));
        //$this->reservationStart = NULL;
        //$this->reservationEnd = NULL;
    }

    /**
     * id 
     */
    public function getId() {return $this->id;}

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
     * namePublic
     */
    public function setNamePublic($namePublic)
    {
        $this->namePublic = $namePublic;
        return $this;
    }
    public function getNamePublic() {return $this->namePublic;}

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
     * scheduleStart
     */
	 /*
    public function setScheduleStart($scheduleStart)
    {
        $this->scheduleStart = $scheduleStart;
        return $this;
    }
    public function getScheduleStart() {return $this->scheduleStart;}
	*/

    /**
     * scheduleEnd
     */
	/*
    public function setScheduleEnd($scheduleEnd)
    {
        $this->scheduleEnd = $scheduleEnd;
        return $this;
    }
    public function getScheduleEnd() {return $this->scheduleEnd;}
	*/

    /**
     * reservationStart
     */
	/*
    public function setReservationStart($reservationStart)
    {
        $this->reservationStart = $reservationStart;
        return $this;
    }
    public function getReservationStart() {return $this->reservationStart;}
	*/

    /**
     * reservationEnd
     */
	/*
    public function setReservationEnd($reservationEnd)
    {
        $this->reservationEnd = $reservationEnd;
        return $this;
    }
    public function getReservationEnd() {return $this->reservationEnd;}
	*/

    /**
     * reservation time remaining
     */
	/*
    public function reservationTimeRemaining() {
        if ($this->getReservationEnd() != null) {
            $now = new \DateTime();
            $deadline = $this->getReservationEnd();
            $diff = $deadline->getTimestamp() - $now->getTimestamp();

            $diff_result = array("seconds" => $diff);
            if ($diff < 3600) {$diff_result["type"] = "minutes"; $diff_result["value"] = $deadline->diff($now)->format('%I'); $diff_result["trans"] = "planning.reservation.timeremaining.minutes";}
            elseif ($diff < 86400) {$diff_result["type"] = "hours"; $diff_result["value"] = $deadline->diff($now)->format('%H'); $diff_result["trans"] = "planning.reservation.timeremaining.hours";}
            else {$diff_result["type"] = "days"; $diff_result["value"] = $deadline->diff($now)->format('%D'); $diff_result["trans"] = "planning.reservation.timeremaining.days";}

            return $diff_result;
        } else {return FALSE;}
    }
	*/

    /**
     * planning status
     */
	/*
    public function status() {
        $status = array("type" => "open", "open" => true);
        $now = new \DateTime();

        if ($this->enabled == 0) {$status["type"] = "inactivate"; $status["open"] = false;}
        elseif ($this->getReservationStart() != null AND $this->getReservationStart() > $now) {$status["type"] = "opening"; $status["open"] = false;}
        elseif ($this->getReservationEnd() != null AND $this->getReservationEnd() >= $now) {$status["type"] = "closing"; $status["open"] = true;}
        elseif ($this->getReservationEnd() != null AND $this->getReservationEnd() < $now) {$status["type"] = "close"; $status["open"] = false;}

        return $status;
    }
	*/

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
     * Packages
     */
    //public function getPackages() {return $this->packages;}

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
