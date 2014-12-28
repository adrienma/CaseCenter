<?php

namespace Casecenter\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Page
 *
 * @ORM\Table(name="pages")
 * @ORM\Entity(repositoryClass="Casecenter\SupportBundle\Entity\PageRepository")
 * @UniqueEntity(fields={"support", "slug"}, message="This slug is already used.")
 * @Gedmo\SoftDeleteable(fieldName="archive", timeAware=false)
 */
class Page
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Casecenter\SupportBundle\Entity\Support", inversedBy="pages")
     * @ORM\JoinColumn(name="support_id", referencedColumnName="id", nullable=false)
     */
    private $support;
    
    /**
     * @ORM\Column(name="name", type="string")
     * @Assert\NotBlank(message="Please enter a page name.")
     */
    private $name;

    /**
     * @ORM\Column(name="slug", type="string", unique=true)
     * @Gedmo\Slug(unique_base="support", fields={"name"})
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="Casecenter\SupportBundle\Entity\Format", mappedBy="page")
     */
    private $formats;

    /**
     * @ORM\Column(name="archive", type="datetime", nullable=true)
     */
    private $archive;

    public function __construct() {
        $this->formats = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Id
     */
    public function getId() {return $this->id;}

    /**
     * Support
     */
    public function setSupport(\Casecenter\SupportBundle\Entity\Support $support) {
        $this->support = $support;
        return $this;
    }
    public function getSupport() {return $this->support;}

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
     * Formats
     */
    public function getFormats() {return $this->formats;}

    /**
     * Archive
     */
    public function setArchive($archive) {
        $this->archive = $archive;
        return $this;
    }
    public function getArchive() {return $this->archive;}
}
