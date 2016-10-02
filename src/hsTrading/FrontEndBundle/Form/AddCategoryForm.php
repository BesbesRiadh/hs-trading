<?php

namespace hsTrading\FrontEndBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddCategoryForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('code', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'max_length' => 255,
                    'attr' => array('placeholder' => 'code',
                    )
                ))
                ->add('label', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'max_length' => 255,
                    'attr' => array('placeholder' => 'label',
                    )
                ))
               ;
                
    }


    public function getName()
    {
        return 'AddCategory';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
        ));
    }

}
