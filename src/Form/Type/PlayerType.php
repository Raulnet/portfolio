<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 22/03/2015
 * Time: 23:28
 */

namespace portfolio\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('nickname', 'text')
            ->add('email', 'email', array(
                'required' => false,))
            ->add('support', 'choice', array(
                'choices' => array(
                    '' => '',
                    'ps3' => 'ps3',
                    'ps4' => 'ps4',
                    'XONE' => 'XONE',
                    'X360' => 'X360',
                    'PC' => 'PC',
                ),
                'expanded' => false,
            ))
            ->add('comment', 'textarea', array(
            'required' => false,));
    }

    public function getName()
    {
        return 'player';
    }
} 