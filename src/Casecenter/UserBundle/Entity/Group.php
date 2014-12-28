<?php

namespace Casecenter\UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="users_groups")
 * @Gedmo\SoftDeleteable(fieldName="archive", timeAware=false)
 */
class Group extends BaseGroup
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
    * @ORM\Column(name="archive", type="datetime", nullable=true)
    */
    protected $archive;

    /**
    * archive
    */
    public function setArchive($archive) {$this->archive = $archive;}
    public function getArchive() {return $this->archive;}
}