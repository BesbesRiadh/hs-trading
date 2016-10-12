<?php

namespace hsTrading\FrontEndBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use hsTrading\FrontEndBundle\Utils\EchTools;

class AddSubCategoryForm extends AbstractType
{

    public function __construct($aOptions = array())
    {
        $this->aCategory = EchTools::getOption($aOptions, 'category');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('productCategory_id', 'choice', array(
                    'choices' => $this->aCategory
                ))
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
                ->add('categorder', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'max_length' => 255,
                    'attr' => array('placeholder' => 'categorder',
                    )
                ))
        ;
    }

    public function getName()
    {
        return 'AddSubCategory';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
        ));
    }

}
