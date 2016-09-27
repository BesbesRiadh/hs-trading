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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('category', 'choice', array(
                    'choices' => array('agro' => 'Agroalimentaire'
                        , 'pab' => 'Produits Alimentaires Bio'
                        , 'par' => 'Produits Artisanaux'
                        , 'pcb' => 'Produits Cosmétiques Bio'
                        , 'ph' => 'Produits Hygiéniques'
                        , 'divers' => 'Divers'
                        ),
                    'required' => true,
                    'trim' => true,
                    'max_length' => 255,
                    'empty_value' => 'category',
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
                ->add('img', 'textarea', array(
                    'required' => true,
                    'trim' => true,
                    'attr' => array('placeholder' => 'img', 'style' => 'width: 800px; height: 140px; resize:none;'
                    )
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
