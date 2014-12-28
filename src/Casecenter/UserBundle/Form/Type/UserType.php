<?php

namespace Casecenter\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

class UserType extends AbstractType
{
    private $securityContext;

    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Généralités
        $builder
            ->add('name', 'text', array('label' => 'form.name', 'translation_domain' => 'FOSUserBundle'))
            ->add('firstname', 'text', array('label' => 'form.firstname', 'translation_domain' => 'FOSUserBundle'))
            ->add('company', 'text', array('label' => 'form.company', 'translation_domain' => 'FOSUserBundle'))
            ->add('function', 'text', array('label' => 'form.function', 'translation_domain' => 'FOSUserBundle'))
            ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            //->add('password', 'checkbox', array('label' => 'form.password_regenerate', 'translation_domain' => 'FOSUserBundle', 'required' => false, 'mapped' => false, 'help' => 'form.password_regenerate_help'))
            //->add('credentialsExpireAt', 'datetime', array('label' => 'form.credentialsexpired.label', 'translation_domain' => 'FOSUserBundle', 'widget' => 'single_text', 'format' => 'dd/MM/yyyy HH:mm', 'date_format' => 'dd/MM/yyyy HH:mm', 'required' => false, 'help' => 'form.credentialsexpired.help'))
            //->add('credentialsExpired', 'checkbox', array('required' => false))
            ->add('locked', 'checkbox', array('label' => 'form.locked.label', 'translation_domain' => 'FOSUserBundle', 'required' => false, 'help' => 'form.locked.help'))
            ->add('expiresAt', 'datetime', array('label' => 'form.expired.label', 'translation_domain' => 'FOSUserBundle', 'widget' => 'single_text', 'format' => 'dd/MM/yyyy HH:mm', 'date_format' => 'dd/MM/yyyy HH:mm', 'required' => false, 'help' => 'form.expired.help'))
            //->add('groups', '')
            ->add('locale', 'locale', array('label' => 'form.locale.label', 'translation_domain' => 'FOSUserBundle', 'preferred_choices' => array('fr_FR', 'en_GB'), 'required' => false))
        ;


        if ($this->securityContext->isGranted('ROLE_SUPER_ADMIN')) {$builder->add('username', 'text', array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'));}

        //Droits
        if ($this->securityContext->isGranted('ROLE_SUPER_ADMIN')) {$builder->add('superadmin', 'checkbox', array('label' => 'user.role.superadmin', 'required' => false));}
        if ($this->securityContext->isGranted('ROLE_PLANNING_ADMIN')) {$builder->add('roleplanning', 'choice', array('label' => 'user.form.role.planning.label', 'choices' => array('none' => 'user.role.none', 'user' => 'user.role.user', 'admin' => 'user.role.admin')));}
        if ($this->securityContext->isGranted('ROLE_CAMPAIGN_ADMIN')) {$builder->add('rolecampaign', 'choice', array('label' => 'user.form.role.campaign.label', 'choices' => array('none' => 'user.role.none', 'user' => 'user.role.user', 'admin' => 'user.role.admin')));}
        if ($this->securityContext->isGranted('ROLE_PARTNER_ADMIN')) {$builder->add('rolepartner', 'choice', array('label' => 'user.form.role.partner.label', 'choices' => array('none' => 'user.role.none', 'user' => 'user.role.user', 'admin' => 'user.role.admin')));}
        if ($this->securityContext->isGranted('ROLE_PROJECT_ADMIN')) {$builder->add('roleproject', 'choice', array('label' => 'user.form.role.project.label', 'choices' => array('none' => 'user.role.none', 'user' => 'user.role.user', 'admin' => 'user.role.admin')));}
        if ($this->securityContext->isGranted('ROLE_REPORT_ADMIN')) {$builder->add('rolereport', 'choice', array('label' => 'user.form.role.report.label', 'choices' => array('none' => 'user.role.none', 'user' => 'user.role.user', 'admin' => 'user.role.admin')));}
        if ($this->securityContext->isGranted('ROLE_WIKI_ADMIN')) {$builder->add('rolewiki', 'choice', array('label' => 'user.form.role.wiki.label', 'choices' => array('none' => 'user.role.none', 'user' => 'user.role.user', 'admin' => 'user.role.admin')));}
        $builder->add('admin', 'checkbox', array('label' => 'user.form.role.admin.label', 'required' => false, "help" => "user.form.role.admin.help"));

        $builder->add('save', 'submit', array('label' => 'form.btn.save'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Casecenter\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user';
    }
}
