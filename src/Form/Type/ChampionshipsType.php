<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 16/08/15
 * Time: 21:08
 */

namespace portfolio\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ChampionshipsType extends AbstractType {

    /**
     * @var bool
     */
    private $edit;

    /**
     * @var array
     */
    private $results = array();

    public function __construct($edit = false, $results = array())
    {
        $this->edit = $edit;
        $this->results = $results;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cha_title', 'text', array(
            'label' => 'Titre :',
            'attr' => array(
                'class' => 'form-control'
            )));
        // IF Edit add grid points
        if($this->edit){
            $builder
                ->add('result_id', 'choice', array(
                    'label' => 'Resultat :',
                    'empty_value' => 'Choisissez une option',
                    'choices' => $this->results,
                    'attr' => array(
                        'class' => 'form-control'
                    )));
        }

        $builder->add('enregistrer', 'submit', array(
            'attr' => array('class' => 'btn btn-success')
        ));

    }

    public function getName()
    {
        return 'championship';
    }
}