<?php

namespace hsTrading\FrontEndBundle\Form;

use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints as Assert;
use hsTrading\FrontEndBundle\Utils\EchTools;

/**
 * Description of AddUserForm
 *
 * @author SSH1
 */
class EditProductForm extends AbstractType
{

    public function __construct($aOptions = array(), $aOptions2 = array())
    {
        $this->aCategoryChoice    = EchTools::getOption($aOptions2, 'cat');
        $this->aSubCategoryChoice = EchTools::getOption($aOptions2, 'subcat');
        $this->aCategory          = EchTools::getOption($aOptions2, 'category');
        $this->aSubCategory       = EchTools::getOption($aOptions2, 'sub_category');
        $this->aDesignation       = EchTools::getOption($aOptions, 'designation');
        $this->aDescription       = EchTools::getOption($aOptions, 'description');
        $this->aDesigeng          = EchTools::getOption($aOptions, 'desigeng');
        $this->aDesceng           = EchTools::getOption($aOptions, 'desceng');
        $this->sPrice             = EchTools::getOption($aOptions, 'price');
        $this->sImage             = EchTools::getOption($aOptions, 'img');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('id_category', 'choice', array(
                    'choices' => $this->aCategoryChoice,
                    'required' => true,
                    'data' => $this->aCategory,
                    'trim' => true,
                    'max_length' => 255,
                ))
                ->add('id_category_details', 'choice', array(
                    'choices' => $this->aSubCategoryChoice,
                    'required' => true,
                    'data' => $this->aCategory,
                    'trim' => true,
                    'max_length' => 255,
                ))
                ->add('designation', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'data' => $this->aDesignation,
                    'max_length' => 255,
                    'attr' => array('placeholder' => 'designation',
                    )
                ))
                ->add('desigeng', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'data' => $this->aDesigeng,
                    'max_length' => 255,
                    'attr' => array('placeholder' => 'designation english',
                    )
                ))
                ->add('description', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'data' => $this->aDescription,
                    'max_length' => 255,
                    'attr' => array('placeholder' => 'description',
                    )
                ))
                ->add('desceng', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'data' => $this->aDesceng,
                    'max_length' => 255,
                    'attr' => array('placeholder' => 'description english',
                    )
                ))
                ->add('price', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'data' => $this->sPrice,
                    'max_length' => 255,
                    'attr' => array('placeholder' => 'price',
                    )
                ))
                ->add('img', 'textarea', array(
                    'required' => true,
                    'trim' => true,
                    'data' => $this->sImage,
                    'attr' => array('placeholder' => 'img', 'style' => 'width: 800px; height: 140px; resize:none;'
                    )
        ));
    }

    public function getName()
    {
        return 'EditProduct';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
        ));
    }

}
