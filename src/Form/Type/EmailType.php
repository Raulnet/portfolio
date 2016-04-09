<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 16/01/2016
 * Time: 21:31
 */
namespace portfolio\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class EmailType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', 'textarea');
        $builder->add('value_test', 'integer', array());
        $builder->add('submit', 'submit', array(
            'envoyer'
        ));
    }

    public function getName()
    {
        return 'comment';
    }
}
