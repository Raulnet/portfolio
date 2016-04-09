<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 06/09/15
 * Time: 23:18
 */

namespace portfolio\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use portfolio\Model\Results;

class ResultsType extends AbstractType {


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('res_type', 'choice', array(
                'choices' => Results::$results,
                'label' => 'Type :',
                'attr' => array(
                    'class' => 'form-control'
                )));
        $builder
            ->add('res_title', 'text', array(
                'label' => 'Titre :',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Titre du résultat',
                )));
        $builder
            ->add('res_sequence', 'integer', array(
                'label' => 'Sequence :',
                'attr' => array(
                    'class' => 'form-control',
                    'value' => 1,
                )));
        $builder
            ->add('grids_points_id', 'choice', array(
                'choices' => array(
                    'empty_value' => 'Choisissez une grille',
                    1  => 'GTfusion',
                    2  => 'Formula 1 2015',
                    3  => 'Drift',
                ),
                'label' => 'Grille de points :',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',

                )));
        $builder
            ->add('res_sort', 'choice', array(
                'choices' => array(
                    'DESC'  => 'DESC',
                    'ASC' => 'ASC',
                ),
                'label' => 'Rank :',
                'attr' => array(
                    'class' => 'form-control'
                )));
        $builder->add('enregistrer', 'submit', array(
            'attr' => array('class' => 'btn btn-success',
            'name' => 'créer',
            )
        ));
    }

    public function getName()
    {
        return 'results';
    }

}