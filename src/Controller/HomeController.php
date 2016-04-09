<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 09/03/15
 * Time: 20:05
 */

namespace portfolio\Controller;


use portfolio\Form\Type\EmailType;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{

    /**
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app)
    {
        return $app['twig']->render('index.html.twig', array());
    }

    /**
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function contactAction(Application $app)
    {
        $request = $app['request'];
        if($request->get('human') == date('H')+date('d')){ //test the human reponse

            $message = \Swift_Message::newInstance()
                ->setSubject('Contact from website')
                ->setFrom(array($request->get('email') => $request->get('name')))
                ->setTo(array('laurentnegre016@gmail.com'))
                ->setBody($request->get('message'));
            $app['mailer']->send($message);
            $contact = true;
        }
        else{
            $contact = false;
        }
        return $app->redirect('/');

    }

    /**
     * User login controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function loginAction(Request $request, Application $app)
    {
        return $app['twig']->render('login.html.twig', array(
            'error' => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
    }

    public function testEmailsAction(Application $app, Request $request){

    }

    private function getEmailRender(Application $app, $content){

        $form = $app['form.factory']->create(new EmailType(), array(), array(
            'method' => 'POST',
            'action' => $this->urlGenerator($app)->generate('test_emails')
        ));


       return $app['twig']->render('template/email/_default.html.twig', array(
           'message' => $content,
           'form' => $form
       ));

    }



}