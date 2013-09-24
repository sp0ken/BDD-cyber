<?php

namespace Urbicande\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array(
                'label' => 'Nom d‘utilisateur'
            ))
            ->add('email', null, array(
                'label' => 'E-mail'
            ))
            ->add('plainPassword', 'repeated', array(
              'type' => 'password',
              'invalid_message' => 'Les champs ne correspondent pas.',
              'options' => array('attr' => array('class' => 'password-field')),
              'required' => false,
              'first_options'  => array('label' => 'Nouveau mot de passe'),
              'second_options' => array('label' => 'Confirmation du nouveau mot de passe'),
          ))
          ->add('setting', new SettingType())
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbicande\UserBundle\Entity\User',
            'csrf_protection' => true,
            'cascade_validation' => true
        ));
    }

    public function getName()
    {
        return 'urbicande_userbundle_usertype';
    }
}
