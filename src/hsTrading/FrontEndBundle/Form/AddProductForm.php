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
class AddProductForm extends AbstractType
{
    
    public function __construct($aOptions = array())
    {
        $this->aListCat  = EchTools::getOption($aOptions, 'cat');
        $this->aListSubCat = EchTools::getOption($aOptions, 'subcat');
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('id_category', 'choice', array(
                    'choices' => $this->aListCat,
                    'required' => true,
                    'trim' => true,
                    'max_length' => 255,
                    'empty_value' => 'category',
                    'constraints' => array(
                        new Constraints\NotBlank(),
                    )
                ))
                ->add('id_category_details', 'choice', array(
                    'choices' => $this->aListSubCat,
                    'required' => true,
                    'trim' => true,
                    'max_length' => 255,
                    'empty_value' => 'sub_category',
                    'constraints' => array(
                        new Constraints\NotBlank(),
                    )
                ))
                ->add('designation', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'max_length' => 255,
                    'attr' => array('placeholder' => 'designation',
                    )
                ))
                ->add('description', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'max_length' => 255,
                    'attr' => array('placeholder' => 'description',
                    )
                ))
                ->add('price', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'max_length' => 255,
                    'attr' => array('placeholder' => 'price',
                    )
                ))
                ->add('img', 'file', array(
                    'mapped' => true,
//                    'attr' => array('placeholder' => 'img', 'style' => 'width: 800px; height: 140px; resize:none;'
//                    )
                ));
                
    }


    public function getName()
    {
        return 'AddProduct';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
        ));
    }

}
