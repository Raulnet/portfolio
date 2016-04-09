<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 18/03/2015
 * Time: 10:13
 */

namespace portfolio\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ResultLadderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('minute', 'integer', array('attr' => array('min' => 0, 'max' => 59)))
                ->add('seconde', 'integer', array('attr' => array('min' => 0, 'max' => 59)))
                ->add('milliseconde', 'integer', array('attr' => array('min' => 0, 'max' => 999)))
        ;
    }

    public function getName()
    {
        return 'result';
    }

}