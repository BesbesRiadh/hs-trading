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
class EditProductForm extends AbstractType {

    public function __construct($aOptions = array()) {
        $this->aCategory = EchTools::getOption($aOptions, 'category');
        $this->aDesignation = EchTools::getOption($aOptions, 'designation');
        $this->aDescription = EchTools::getOption($aOptions, 'description');
        $this->sPrice = EchTools::getOption($aOptions, 'price');
        $this->sImage = EchTools::getOption($aOptions, 'img');
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
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
                    'data' => $this->aCategory,
                    'trim' => true,
                    'max_length' => 255,
                    'empty_value' => 'category',
                ))
                ->add('designation', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'data' => $this->aDesignation,
                    'max_length' => 255,
                    'attr' => array('placeholder' => 'designation',
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

    public function getName() {
        return 'EditProduct';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
        ));
    }

}