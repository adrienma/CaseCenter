<?php

namespace Casecenter\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Casecenter\UserBundle\Entity\UserRepository")
 * @ORM\Table(name="users")
 * @Gedmo\SoftDeleteable(fieldName="archive", timeAware=false)
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please enter your name.")
     * @Assert\Length(min=3, max="255", minMessage="The name is too short.", maxMessage="The name is too long.")
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please enter your first name.")
     * @Assert\Length(min=3, max="255", minMessage="The first name is too short.", maxMessage="The first name is too long.")
     */
    protected $firstname;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please enter your company.")
     * @Assert\Length(min=3, max="255", minMessage="The company is too short.", maxMessage="The company is too long.")
     */
    protected $company;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please enter your function.")
     * @Assert\Length(min=3, max="255", minMessage="The function is too short.", maxMessage="The function is too long.")
     */
    protected $function;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    protected $locale;

    /**
     * @ORM\ManyToMany(targetEntity="Casecenter\UserBundle\Entity\Group")
     * @ORM\JoinTable(name="users_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @ORM\Column(name="archive", type="datetime", nullable=true)
     */
    private $archive;
    
    public function __construct()
    {
    	parent::__construct();

        $this->username = substr($this->firstname, 0, 1).$this->name;
        $this->password = uniqid(rand(), true);
        //$this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    public function getName()
    {
        return $this->name;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }
    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getFullname($way = NULL)
    {
       if ($way == "firstname-name") {return $this->firstname." ".$this->name;}
       else {return $this->name." ".$this->firstname;}
    }

    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }
    public function getCompany()
    {
        return $this->company;
    }

    public function setFunction($function)
    {
        $this->function = $function;
        return $this;
    }
    public function getFunction()
    {
        return $this->function;
    }

    public function getLocale() {return $this->locale;}
    public function setLocale($locale) {$this->locale = $locale;}

    public function getExpiresAt() {return $this->expiresAt;}
    public function isAccountExpirable() {if ($this->expiresAt != null) {return true;} else {return false;}}
    public function getCredentialsExpireAt() {return $this->credentialsExpireAt;}

    public function getSuperAdmin() {if ($this->isSuperAdmin()) {return TRUE;} else {return FALSE;}}
    public function isAdmin() {return $this->hasRole('ROLE_ADMIN');}
    public function setAdmin($boolean)
    {
        if (true === $boolean) {$this->addRole('ROLE_ADMIN');}
        else {$this->removeRole('ROLE_ADMIN');}
        return $this;
    }
    public function getAdmin() {if ($this->isAdmin()) {return TRUE;} else {return FALSE;}}
    public function setRoleModule($module, $role)
    {
        $module = strtoupper($module);
        if ($role == 'admin') {$this->addRole('ROLE_'.$module.'_ADMIN'); $this->removeRole('ROLE_'.$module);}
        elseif ($role == 'user') {$this->removeRole('ROLE_'.$module.'_ADMIN'); $this->addRole('ROLE_'.$module);}
        else {$this->removeRole('ROLE_'.$module.'_ADMIN'); $this->removeRole('ROLE_'.$module);}
        return $this;
    }
    public function getRoleModule($module)
    {
        $module = strtoupper($module);
        if ($this->hasRole('ROLE_'.$module.'_ADMIN')) {return 'admin';}
        elseif ($this->hasRole('ROLE_'.$module)) {return 'user';}
        else {return null;}
    }
    public function setRolePlanning($role) {return $this->setRoleModule('PLANNING', $role);}
    public function getRolePlanning() {return $this->getRoleModule('PLANNING');}
    public function setRoleCampaign($role) {return $this->setRoleModule('CAMPAIGN', $role);}
    public function getRoleCampaign() {return $this->getRoleModule('CAMPAIGN');}
    public function setRolePartner($role) {return $this->setRoleModule('PARTNER', $role);}
    public function getRolePartner() {return $this->getRoleModule('PARTNER');}
    public function setRoleProject($role) {return $this->setRoleModule('PROJECT', $role);}
    public function getRoleProject() {return $this->getRoleModule('PROJECT');}
    public function setRoleReport($role) {return $this->setRoleModule('REPORT', $role);}
    public function getRoleReport() {return $this->getRoleModule('REPORT');}
    public function setRoleWiki($role) {return $this->setRoleModule('WIKI', $role);}
    public function getRoleWiki() {return $this->getRoleModule('WIKI');}
}
