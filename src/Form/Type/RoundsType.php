<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 21/08/15
 * Time: 22:32
 */

namespace portfolio\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RoundsType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rou_title', 'text', array(
                'label' => 'Titre :',
                'attr' => array(
                    'class' => 'form-control'
                )))
//            ->add('rou_sequence', 'number', array(
//                'label' => 'sequence :',
//                'attr' => array(
//                    'class' => 'form-control'
//                )))
//            ->add('rou_number_result', 'number', array(
//                'label' => 'number result :',
//                'attr' => array(
//                    'class' => 'form-control'
//                )))
            ->add('stage_id', 'hidden')
            ->add('enregistrer', 'submit', array(
                'attr' => array('class' => 'btn btn-success')
            ));
    }

    public function getName()
    {
        return 'rounds';
    }
}