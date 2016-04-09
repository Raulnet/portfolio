<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 22/06/15
 * Time: 22:30
 */
namespace portfolio\Command\Generator;

abstract class AbstractGenerator
{

    /**
     * @return string
     */
    abstract public function getRoot();

    /**
     * @param null $table
     *
     * @return mixed
     */
    abstract public function getTitleFile($table = null);

    /**
     * @param $title
     *
     * @return string
     */
    protected function getTitleToCamelCase($title)
    {
        $titleToCamelCase = '';
        $explo            = explode('_', $title);
        // supprime l'index table si celui-ci a une taille inferieur ou = a 3
        if (strlen($explo[0]) <= 3) {
            unset($explo[0]);
        }
        foreach ($explo as $word) {
            $titleToCamelCase .= ucfirst(strtolower($word));
        }

        return $titleToCamelCase;
    }


}