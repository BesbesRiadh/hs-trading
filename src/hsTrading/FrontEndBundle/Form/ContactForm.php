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
 * Description of ContactForm
 *
 * @author Ramy
 */
class ContactForm extends AbstractType
{

    public function __construct($aOptions = array())
    {
        $this->countries = EchTools::getOption($aOptions, 'countries');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('mail', 'email', array(
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'mail',
                        'autocomplete' => 'off',
                        'class' => 'form-control'
                    ),
                    'constraints' => array(
                        new Assert\NotBlank(),
                        new Constraints\Email(array(
                            'checkMX' => true,
                            'checkHost' => true,
                            'message' => "ampv"
                                )),
                    ),
                        )
                )
                ->add('phone', 'text', array(
                    'required' => false,
                    'trim' => true,
                    'max_length' => 8,
                    'attr' => array('placeholder' => 'phone',
                        'autocomplete' => 'off',
                        'class' => 'form-control'
                    ),
                    'constraints' => array(
                        new Assert\Regex(array(
                            'pattern' => "/^[0-9]{8}+$/",
                            'match' => true,
                            'message' => "ntpv")),
                        new Constraints\Length(array(
                            'min' => 2,
                            'max' => 8,
                                )),
                    )
                ))
                ->add('firstname', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'max_length' => 8,
                    'constraints' => array(
                        new Constraints\NotBlank(),
                        new Assert\Regex(array(
                            'pattern' => "/^[a-zA-Zéèêëïöôùç -'‘]+$/",
                            'match' => true,
                            'message' => "ppv"))
                    ),
                    'attr' => array('placeholder' => 'firstname',
                        'autocomplete' => 'off',
                        'class' => 'form-control'
                    ),
                ))
                ->add('lastname', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'max_length' => 8,
                    'constraints' => array(
                        new Constraints\NotBlank(),
                        new Assert\Regex(array(
                            'pattern' => "/^[a-zA-Zéèêëïöôùç -'‘]+$/",
                            'match' => true,
                            'message' => "npv"))
                    ),
                    'attr' => array('placeholder' => 'lastname',
                        'autocomplete' => 'off',
                        'class' => 'form-control'
                    ),
                ))
                ->add('company', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'max_length' => 8,
                    'attr' => array('placeholder' => 'company',
                        'autocomplete' => 'off',
                        'class' => 'form-control'
                    ),
                    'constraints' => array(new Assert\Regex(array(
                            'pattern' => '/\w{0,100}/',
                            'match' => true,
                            'message' => "nspv")
                        ),
                        new Assert\NotBlank(),
                    )
                ))
                ->add('company_function', 'text', array(
                    'required' => false,
                    'trim' => true,
                    'max_length' => 8,
                    'attr' => array('placeholder' => 'function',
                        'autocomplete' => 'off',
                        'class' => 'form-control'
                    ),
                    'constraints' => array(
                        new Constraints\NotBlank(),
                        new Assert\Regex(array(
                            'pattern' => "/^[a-zA-Zéèêëïöôùç -'‘]+$/",
                            'match' => true,
                            'message' => "cpv"))
                    ),
                ))
                ->add('object', 'text', array(
                    'required' => true,
                    'trim' => true,
                    'max_length' => 8,
                    'attr' => array('placeholder' => 'object',
                        'autocomplete' => 'off',
                        'class' => 'form-control'
                    ),
                    'constraints' => array(
                        new Constraints\NotBlank(),
                        new Assert\Regex(array(
                            'pattern' => "/^[a-zA-Zéèêëïöôùç -'‘]+$/",
                            'match' => true,
                            'message' => "opv"))
                    ),
                ))
                ->add('country', 'choice', array(
                    'required' => true,
                    'label' => 'country',
                    'empty_value' => 'Pays',
                    'attr' => array('class' => 'form-control'),
                    'choices' => $this->countries,
                        )
                )
                ->add('message', 'textarea', array(
                    'trim' => true,
                    'required' => true,
                    'label' => 'Message',
                    'attr' => array(
                        'autocomplete' => 'off',
                        'placeholder' => 'Message',
                        'rows' => '4',
                        'class' => 'form-control'
                    ),
        ));

        $this->setTransformer($builder, 'mail');
        $this->setTransformer($builder, 'phone');
        $this->setTransformer($builder, 'firstname');
        $this->setTransformer($builder, 'lastname');
        $this->setTransformer($builder, 'company');
        $this->setTransformer($builder, 'company_function');
        $this->setTransformer($builder, 'object');
        $this->setTransformer($builder, 'message');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
                array(
                    'csrf_protection' => true,
                )
        );
    }

    private function setTransformer($builder, $field)
    {
        $builder->get($field)
                ->addModelTransformer(new CallbackTransformer(
                        function ($originalDescription)
                {
                    return $originalDescription;
                }, function ($submittedDescription)
                {
                    // remove most HTML tags (but not br)
                    $cleaned = strip_tags($submittedDescription);

                    return $cleaned;
                }
        ));
    }

    public function getName()
    {
        return 'contact';
    }

}
