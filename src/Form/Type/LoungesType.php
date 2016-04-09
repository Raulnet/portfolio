<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 18/08/15
 * Time: 22:15
 */

namespace portfolio\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoungesType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lou_title', 'text', array(
                'label' => 'Titre :',
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('stage_id', 'hidden')
            ->add('enregistrer', 'submit', array(
                'attr' => array('class' => 'btn btn-success')
            ));
    }

    public function getName()
    {
        return 'lounges';
    }

}