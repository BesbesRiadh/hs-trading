<?php

namespace hsTrading\FrontEndBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use hsTrading\FrontEndBundle\Utils\EchTools;

class EditCategoryForm extends AbstractType
{
     public function __construct($aOptions = array()) {
        $this->aCode = EchTools::getOption($aOptions, 'code');
        $this->aLabel = EchTools::getOption($aOptions, 'label');
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('code', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'max_length' => 255,
                    'data' => $this->aCode,
                    'attr' => array('placeholder' => 'code',
                    )
                ))
                ->add('label', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'data' => $this->aLabel,
                    'max_length' => 255,
                    'attr' => array('placeholder' => 'label',
                    )
                ))
               ;
                
    }


    public function getName()
    {
        return 'EditCategory';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
        ));
    }

}
