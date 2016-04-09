<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 16/08/15
 * Time: 23:34
 */

namespace portfolio\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class StagesType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sta_title', 'text', array(
                'label' => 'Titre :',
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('sta_sequence', 'integer', array(
                'label' => 'Sequence :',
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('championship_id', 'hidden')
            ->add('enregistrer', 'submit', array(
                'attr' => array('class' => 'btn btn-success')
            ));
    }

    public function getName()
    {
        return 'stage';
    }
}