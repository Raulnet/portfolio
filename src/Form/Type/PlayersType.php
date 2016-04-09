<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 23/08/15
 * Time: 01:32
 */

namespace portfolio\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
class PlayersType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pla_nickname', 'text', array(
                'label' => 'Pseudo :',
                'attr' => array(
                    'class' => 'form-control'
                )))
            ->add('enregistrer', 'submit', array(
                'attr' => array('class' => 'btn btn-success')
            ));
    }

    public function getName()
    {
        return 'player';
    }
}