<?php

namespace Casecenter\PlanningBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('advertiser', 'text', array('label' => 'booking.form.advertiser'))
            ->add('campaign', 'text', array('label' => 'booking.form.campaign'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Casecenter\PlanningBundle\Entity\Booking'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'casecenter_planningbundle_booking';
    }
}
