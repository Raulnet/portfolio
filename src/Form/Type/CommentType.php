<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 08/03/15
 * Time: 18:06
 */

namespace portfolio\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;



class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', 'textarea');
    }

    public function getName()
    {
        return 'comment';
    }
}