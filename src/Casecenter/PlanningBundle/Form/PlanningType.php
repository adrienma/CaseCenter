<?php

namespace Casecenter\PlanningBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanningType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'planning.form.name'))
            ->add('namePublic', 'text', array('label' => 'planning.form.namePublic'))
            ->add('enabled', 'checkbox', array('label' => 'planning.form.enabled', 'required'  => false))
            //->add('scheduleStart', 'date', array('label' => 'planning.form.scheduleStart', 'widget' => 'single_text', 'input'  => 'datetime'))
            //->add('scheduleEnd', 'date', array('label' => 'planning.form.scheduleEnd', 'widget' => 'single_text', 'input'  => 'datetime'))
            //->add('reservationStart', 'datetime', array('label' => 'planning.form.reservationStart', 'required' => false, 'widget' => 'single_text', 'attr' => array('placeholder' => 'datetime.format')))
            //->add('reservationEnd', 'datetime', array('label' => 'planning.form.reservationEnd', 'required' => false, 'widget' => 'single_text', 'attr' => array('placeholder' => 'datetime.format')))
            ->add('vignette', 'url', array('label' => 'planning.form.vignette', 'required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Casecenter\PlanningBundle\Entity\Planning'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'casecenter_planningbundle_planning';
    }
}
