<?php

namespace Casecenter\WikiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Category
 *
 * @ORM\Table(name="wk_categories")
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 * @UniqueEntity(fields={"slug"}, message="This slug is already used.")
 * @Gedmo\SoftDeleteable(fieldName="archive", timeAware=false)
 */
class Category
{
	/**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $parent;

    /**
     * @ORM\Column(name="archive", type="datetime", nullable=true)
     */
    protected $archive;

    public function __construct() {
    }

    /**
     * id
     */
    public function getId() {return $this->id;}

	/**
     * title
     */
    public function setTitle($title) {$this->title = $title;}
    public function getTitle() {return $this->title;}

    /**
     * slug
     */
    public function setSlug($slug) {$this->slug = $slug;}
    public function getSlug() {return $this->slug;}

    /**
     * parent
     */
    public function setParent(Category $parent = null) {$this->parent = $parent;}
    public function getParent() {return $this->parent;}

    /**
     * archive
     */
    public function setArchive($archive) {$this->archive = $archive;}
    public function getArchive() {return $this->archive;}
}