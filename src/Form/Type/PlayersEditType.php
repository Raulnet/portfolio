<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 30/08/15
 * Time: 18:41
 */

namespace portfolio\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PlayersEditType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pla_nickname', 'text', array(
                'label' => 'Pseudo :',
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('pla_mail', 'email', array(
                'label' => 'Email :',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('pla_support', 'choice', array(
                'label' => 'Support :',
                'choices' => array(
                    '' => '',
                    'ps3' => 'ps3',
                    'ps4' => 'ps4',
                    'XONE' => 'XONE',
                    'X360' => 'X360',
                    'PC' => 'PC',
                ),
                'expanded' => false,
                'attr' => array(
                    'class' => 'form-control')
            ))
            ->add('pla_comment', 'textarea', array(
                'label' => 'Commentaire :',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control')))
            ->add('user_id', 'hidden', array())
            ->add('enregistrer', 'submit', array(
                'attr' => array('class' => 'btn btn-success')
            ));
    }

    public function getName()
    {
        return 'player';
    }

}