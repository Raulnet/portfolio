<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 10/04/2015
 * Time: 12:20
 */

namespace portfolio\Controller;


use Silex\Application;

class GlobalController
{

    /**
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * redirect to homePage with _locale = fr
     */
    public function localeAction(Application $app)
    {

        //TODO GETLOCALE FROM USER'S COOKIE OR LOAD DEFAULT LOCALE

        $app['request']->setLocale('fr');

        $locale = $app['request']->getLocale();

        return $app->redirect('http://rolnet.fr/' . $locale);
    }

}