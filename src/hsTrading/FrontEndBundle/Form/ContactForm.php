<?php

namespace hsTrading\FrontEndBundle\Form;

use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of ContactForm
 *
 * @author Ramy
 */
class ContactForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $bRequired = true;
        $builder
                ->add('mail', 'email', array(
                    'required' => $bRequired,
                    'label' => 'Mail',
                    'attr' => array(
                        'placeholder' => 'Adresse mail',
                        'autocomplete' => 'off',
                    ),
                    'constraints' => array(
                        new Assert\NotBlank(),
                        new Assert\Email(array(
                            'message' => "ampv",
                            'checkMX' => true,
                            'checkHost' => true,
                                )),
                    )
                ))
                ->add('phone', 'text', array(
                    'required' => false,
                    'trim' => true,
                    'max_length' => 8,
                    'label' => 'Phone',
                    'attr' => array('placeholder' => 'Numéro de téléphone',
                        'autocomplete' => 'off',
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
                ->add('message', 'textarea', array(
                    'trim' => true,
                    'required' => true,
                    'label' => 'Message',
                    'attr' => array(
                        'autocomplete' => 'off',
                        'placeholder' => 'Message',
                        'rows' => '4'
                    ),
                ))
                ->get('message')
                ->addModelTransformer(new CallbackTransformer(
                        function ($originalDescription)
                {
                    return preg_replace('#<br\s*/?>#i', "\n", $originalDescription);
                }, function ($submittedDescription)
                {
                    // remove most HTML tags (but not br)
                    $cleaned = strip_tags($submittedDescription, '<br><br/>');

                    // transform any \n to real <br/>
                    return str_replace("\n", '<br/>', $cleaned);
                }
        ));
        ;
        $this->setTransformer($builder, 'mail');
        $this->setTransformer($builder, 'phone');
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
