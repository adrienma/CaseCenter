<?php

namespace Casecenter\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Support
 *
 * @ORM\Table(name="supports")
 * @ORM\Entity(repositoryClass="Casecenter\SupportBundle\Entity\SupportRepository")
 * @UniqueEntity(fields={"slug"}, message="This slug is already used.")
 * @Gedmo\SoftDeleteable(fieldName="archive", timeAware=false)
 */
class Support
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string")
     * @Assert\NotBlank(message="Please enter a support name.")
     */
    private $name;

    /**
     * @ORM\Column(name="slug", type="string", unique=true)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="Casecenter\SupportBundle\Entity\Page", mappedBy="support")
     */
    private $pages;

    /**
     * @ORM\Column(name="archive", type="datetime", nullable=true)
     */
    private $archive;

    public function __construct() {
        $this->pages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Id
     */
    public function getId() {return $this->id;}

    /**
     * Name
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    public function getName() {return $this->name;}

    /**
     * Slug
     */
    public function setSlug($slug) {
        $this->slug = $slug;
        return $this;
    }
    public function getSlug() {return $this->slug;}

    /**
     * Pages
     */
    public function getPages() {return $this->pages;}

    /**
     * Archive
     */
    public function setArchive($archive) {
        $this->archive = $archive;
        return $this;
    }
    public function getArchive() {return $this->archive;}
}
