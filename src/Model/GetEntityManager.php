<?php
/**
 * Created by PhpStorm.
 * User: laurentnegre
 * Date: 24/06/15
 * Time: 23:59
 */

namespace portfolio\Model;

use Silex\Application;

class GetEntityManager {

    /**
     * @var string
     */
    private $rootZEM = '\portfolio\ZEM\\';

    /**
     * @var string
     */
    private $rootZEMGenerated = '\portfolio\ZEM\Generated\\';

    /**
     * @var array
     */
    private $configArray = array();

    /**
     * @var
     */
    private $app;

    /**
     * @param array $configArray
     * @param Application $app
     */
    function __construct(array $configArray, Application $app)
    {
        $this->configArray = $configArray;
        $this->app = $app;
    }

    /**
     * @param $entityManager
     *
     * @return string
     */
    public function get($entityManager){

        if(class_exists($this->rootZEM.$entityManager)){

            $obj = $this->rootZEM.$entityManager;

            return new $obj($this->configArray, $this->app);
        }

        if(class_exists($this->rootZEMGenerated.$entityManager)){

            $obj = $this->rootZEMGenerated.$entityManager;

            return new $obj($this->configArray, $this->app);
        }

        return false;
    }

}