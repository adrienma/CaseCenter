<?php

namespace Casecenter\PlanningBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PackageType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'package.form.name'))
            ->add('vignette', 'url', array('label' => 'package.form.vignette', 'required' => false))
            ->add('enabled', 'checkbox', array('label' => 'package.form.enabled', 'required'  => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Casecenter\PlanningBundle\Entity\Package'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'casecenter_planningbundle_package';
    }
}
