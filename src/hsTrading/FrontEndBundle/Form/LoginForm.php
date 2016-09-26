<?php

namespace hsTrading\FrontEndBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LoginForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login', 'email', array(
                    'required' => true,
                    'trim' => true,
                    'attr' => array(
                        'placeholder' => 'mail_placeholder',
                        'autocomplete' => 'off',
                    ),
                    'max_length' => 255))
                ->add('password', 'password', array(
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'password_placeholder',
                    ),
                    'max_length' => 20))
                
        ;
    }

    public function getName()
    {
        return 'login';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'intention' => 'authentication'
        ));
    }

}
