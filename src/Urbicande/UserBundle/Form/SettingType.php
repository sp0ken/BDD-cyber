<?php

namespace Urbicande\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hasNotification', null, array(
                'label' => 'Activer les notifications par email',
                'required' => false
            ))
            ->add('hasRpg', null, array(
                'label' => 'Activer le RPG',
                'required' => false
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\UserBundle\Entity\Setting',
            'csrf_protection' => true,
        ));
    }

    public function getName()
    {
        return 'urbicande_userbundle_usertype';
    }
}
