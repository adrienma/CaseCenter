<?php

namespace Casecenter\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Format
 *
 * @ORM\Table(name="formats")
 * @ORM\Entity(repositoryClass="Casecenter\SupportBundle\Entity\FormatRepository")
 * @UniqueEntity(fields={"page", "slug"}, message="This slug is already used.")
 * @Gedmo\SoftDeleteable(fieldName="archive", timeAware=false)
 */
class Format {
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Casecenter\SupportBundle\Entity\Page", inversedBy="formats")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", nullable=false)
     */
    private $page;

    /**
     * @ORM\Column(name="name", type="string")
     * @Assert\NotBlank(message="Please enter a format name.")
     */
    private $name;

    /**
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(unique_base="page", fields={"name"})
     */
    private $slug;

    /**
     * @ORM\Column(name="archive", type="datetime", nullable=true)
     */
    private $archive;

    public function __construct() {
    }

    /**
     * Id
     */
    public function getId() {return $this->id;}

    /**
     * Page
     */
    public function setPage(\Casecenter\SupportBundle\Entity\Page $page) {
        $this->page = $page;
        return $this;
    }
    public function getPage() {return $this->page;}

    /**
     * Name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    public function getName() {return $this->name;}

    /**
     * Slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }
    public function getSlug() {return $this->slug;}

    /**
     * Archive
     */
    public function setArchive($archive) {
        $this->archive = $archive;
        return $this;
    }
    public function getArchive() {return $this->archive;}
}
