<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 11/09/15
 * Time: 22:31
 */
namespace portfolio\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $hour = null;
        $minutes = null;
        $seconds = null;
        $milliseconds = null;

        if(false != $options['timer']){
            $timer = $options['timer'];

            $hour = (array_key_exists('hours', $timer)?$timer['hours']:null);
            $minutes = (array_key_exists('minutes', $timer)?$timer['minutes']:null);
            $seconds = (array_key_exists('seconds', $timer)?$timer['seconds']:null);
            $milliseconds = (array_key_exists('milliseconds', $timer)?$timer['milliseconds']:null);
        }
        // if hour is defined addhour input and limit minut input
        if ($options['with_hours']) {
            $builder->add('hours', 'integer', array(
                'required'      => false,
                'attr' => array(
                    'max' => 23,
                    'min' => 0,
                    'placeholder' => 'hour',
                    'value' => ($hour != null ? str_pad($hour, 2, 0, STR_PAD_LEFT) : null),
                )
            ));
            $builder->add('minutes', 'integer', array(
                'required'      => false,
                'attr' => array(
                    'max'           => 59,
                    'min'           => 0,
                    'placeholder'   => 'min',
                    'value'         => ($minutes != null ? str_pad($minutes, 2, 0, STR_PAD_LEFT) : null),
                )
            ));
        }
        // if hours is not defined set full minutes
        if (!$options['with_hours'] && $options['with_minutes']) {

            $builder->add('minutes', 'integer', array(
                'required'      => false,
                'attr' => array(
                    'max'           => 999,
                    'min'           => 0,
                    'placeholder'   => 'min',
                    'value'         => ($minutes != null ? str_pad($minutes, 3, 0, STR_PAD_LEFT) : null),
                )
            ));
        }
        $builder->add('seconds', 'integer', array(
            'required'      => false,
            'attr' => array(
                'max'           => 59,
                'min'           => 0,
                'placeholder'   => 'sc',
                'value'         => ($seconds != null ? str_pad($seconds, 2, 0, STR_PAD_LEFT) : null),
            )
        ));
        if ($options['with_milliseconds']) {
            $builder->add('milliseconds', 'integer', array(
                'required'      => false,
                'attr' => array(
                    'max'           => 999,
                    'min'           => 0,
                    'placeholder'   => 'mill',
                    'value'         => ($milliseconds != null ? str_pad($milliseconds, 3, 0, STR_PAD_LEFT) : null),
                )
            ));
        }
    }


    /**
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'with_hours' => $options['with_hours'],
            'with_milliseconds' => $options['with_milliseconds'],
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'with_hours'   => false,
            'with_minutes'   => true,
            'with_seconds'   => true,
            'with_milliseconds' => true,
            'timer'             => false
        ));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'timer';
    }
}