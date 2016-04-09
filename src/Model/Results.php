<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 13/09/15
 * Time: 01:55
 */

namespace portfolio\Model;

use portfolio\Form\Type\TimerType;
use Symfony\Component\Form\FormBuilderInterface;


class Results {

    const RES_POINT_TO_POINT    = 'RES_POINT_TO_POINT';
    const RES_POS_TO_POINTS     = 'RES_POS_TO_POINTS';
    const RES_TIMER             = 'RES_TIMER';
    const RES_LONG_TIMER        = 'RES_LONG_TIMER';
    const RES_SHORT_TIMER       = 'RES_SHORT_TIMER';

    static $results = array(
        self::RES_POINT_TO_POINT    => 'single points',
        self::RES_POS_TO_POINTS     => 'Positions to points',
        self::RES_TIMER             => 'Chrono m:s,mill',
        self::RES_SHORT_TIMER       => 'Chrono court sc,mill',
        self::RES_LONG_TIMER        => 'Chrono long h:m:s,mil'

    );


    /**
     * @param string                result
     * @param FormBuilderInterface  $form
     * @param array                 $options
     *
     * @return Form
     */
    public function getForm($result, FormBuilderInterface $form, $options = array()){

        if($result === self::RES_POS_TO_POINTS){
            return $this->getFormPosToPoints($form, $options);
        }
        if($result === self::RES_POINT_TO_POINT){
            return $this->getFormToPoints($form, $options);
        }
        if($result === self::RES_TIMER){
            return $this->getFormTimer($form, $options);
        }
        //TODO CREER LES FORMULAIRE *****************************
        if($result === self::RES_SHORT_TIMER){
            return $this->getFormTimer($form, $options);
        }
        if($result === self::RES_LONG_TIMER){
            return $this->getFormTimer($form, $options);
        }

        return $form;
    }

    private function getFormToPoints(FormBuilderInterface $form, $options = array()){
        // Set Attr
        $attr = array(
            'class' => 'form-control positions',
            'min'   => '0'
        );
        if(array_key_exists('metaResult', $options)){
            $attr['value'] = $options['metaResult'];
        }
        if(array_key_exists('max', $options)){
            $attr['max'] = $options['max'];
        }
        // Set Label
        $label = (array_key_exists('label', $options)?$options['label']:'result');

        $form->add('result_'.$options['key'], 'integer', array(
            'label' => $label,
            'required' => false,
            'attr'  => $attr
        ));
        return $form;
    }

    /**
     * @param FormBuilderInterface  $form
     * @param array                 $options
     *
     * @return Form
     */
    private function getFormPosToPoints(FormBuilderInterface $form, $options = array()){

        // Set Attr
        $attr = array(
            'class' => 'form-control positions',
            'min'   => '0'
        );
        if(array_key_exists('metaResult', $options)){
            $attr['value'] = $options['metaResult'];
        }
        if(array_key_exists('max', $options)){
            $attr['max'] = $options['max'];
        }
        // Set Label
        $label = (array_key_exists('label', $options)?$options['label']:'result');

        $form->add('result_'.$options['key'], 'integer', array(
            'label' => $label,
            'required' => false,
            'attr'  => $attr
        ));
        return $form;
    }

    /**
     * @param FormBuilderInterface  $form
     * @param array                 $options
     *
     * @return Form
     */
    private function getFormTimer(FormBuilderInterface $form, $options = array()){

        $attr = array();

        //Set Label
        $label = (array_key_exists('label', $options)?$options['label']:'result');

        $form->add('result_'.$options['key'], new TimerType(), array(
            'label' => $label,
            'required' => false,
            'timer'    => $options['metaResult'],
            'attr'  => $attr
        ));
        return $form;
    }

}