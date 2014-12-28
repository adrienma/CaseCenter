<?php

namespace Casecenter\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('name', 'text', array('label' => 'form.name', 'translation_domain' => 'FOSUserBundle'))
            ->add('firstname', 'text', array('label' => 'form.firstname', 'translation_domain' => 'FOSUserBundle'))
            ->add('company', 'text', array('label' => 'form.company', 'translation_domain' => 'FOSUserBundle'))
            ->add('function', 'text', array('label' => 'form.function', 'translation_domain' => 'FOSUserBundle'))
        ;
    }

    public function getName()
    {
        return 'casecenter_user_registration';
    }
}