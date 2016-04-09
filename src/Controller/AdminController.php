<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 11/03/15
 * Time: 22:19
 */

namespace portfolio\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use portfolio\Domain\Article;
use portfolio\Domain\User;
use portfolio\Domain\Result;
use portfolio\Form\Type\ArticleType;
use portfolio\Form\Type\CommentType;
use portfolio\Form\Type\UserType;
use portfolio\Form\Type\ResultLadderType;
use portfolio\Domain\Player;
use portfolio\Form\Type\PlayerType;

class AdminController
{

    /**
     * Admin home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app)
    {
        $articles = $app['dao.article']->findAll();
        $comments = $app['dao.comment']->findAllOfArticle();
        $commentsMovies = $app['dao.comment']->findAllOfMovie();
        $users = $app['dao.user']->findAll();
        $championships = $app['dao.championship']->findAll();
        $players = $app['dao.player']->findAll();

        return $app['twig']->render('/admin/admin.html.twig', array(
            'articles' => $articles,
            'comments' => $comments,
            'commentsMovies' => $commentsMovies,
            'users' => $users,
            'championships' => $championships,
            'players' => $players,

        ));

    }

    /**
     * Add article controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addArticleAction(Request $request, Application $app)
    {
        $article = new Article();
        $articleForm = $app['form.factory']->create(new ArticleType(), $article);
        $articleForm->handleRequest($request);
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            $app['dao.article']->save($article);
            $app['session']->getFlashBag()->add('success', 'The article was successfully created.');
        }
        return $app['twig']->render('/admin/article_form.html.twig', array(
            'title' => 'New article',
            'articleForm' => $articleForm->createView()));
    }

    /**
     * Edit article controller.
     *
     * @param integer $id Article id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editArticleAction($id, Request $request, Application $app)
    {
        $article = $app['dao.article']->find($id);
        $articleForm = $app['form.factory']->create(new ArticleType(), $article);
        $articleForm->handleRequest($request);
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            $app['dao.article']->save($article);
            $app['session']->getFlashBag()->add('success', 'The article was succesfully updated.');
        }
        return $app['twig']->render('/admin/article_form.html.twig', array(
            'title' => 'Edit article',
            'articleForm' => $articleForm->createView()));
    }

    /**
     * @param $id
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteArticleAction($id, Application $app)
    {
        // Delete all associated comments
        $app['dao.comment']->deleteAllByArticle($id);
        // Delete the article
        $app['dao.article']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The article was succesfully removed.');
        return $app->redirect('/admin');
    }

    /**
     * Edit comment controller.
     *
     * @param integer $id Comment id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editCommentAction($id, Request $request, Application $app)
    {
        $comment = $app['dao.comment']->find($id);
        $commentForm = $app['form.factory']->create(new CommentType(), $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'The comment was succesfully updated.');
        }
        return $app['twig']->render('/admin/comment_form.html.twig', array(
            'title' => 'Edit comment',
            'commentForm' => $commentForm->createView()));
    }

    /**
     * @param $id
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteCommentAction($id, Application $app)
    {
        $app['dao.comment']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The comment was succesfully removed.');
        return $app->redirect('/admin');
    }

    /**
     * Add user controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     * @Se
     */
    public function addUserAction(Request $request, Application $app)
    {
        $user = new User();
        $userForm = $app['form.factory']->create(new UserType(), $user);

        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // generate a random salt value
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $plainPassword = $user->getPassword();
            // find the default encoder
            $encoder = $app['security.encoder.digest'];
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password);
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was successfully created.');
        }
        return $app['twig']->render('/admin/user_form.html.twig', array(
            'title' => 'New user',
            'userForm' => $userForm->createView()));
    }

    /**
     * Edit user controller.
     *
     * @param integer $id User id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editUserAction($id, Request $request, Application $app)
    {
        $user = $app['dao.user']->find($id);
        $userForm = $app['form.factory']->create(new UserType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $plainPassword = $user->getPassword();
            // find the encoder for the user
            $encoder = $app['security.encoder_factory']->getEncoder($user);
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password);
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'The user was succesfully updated.');
        }
        return $app['twig']->render('/admin/user_form.html.twig', array(
            'title' => 'Edit user',
            'userForm' => $userForm->createView()));
    }

    /**
     * @param $id
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteUserAction($id, Application $app)
    {
        // Delete all associated comments
        $app['dao.comment']->deleteAllByUser($id);
        // Delete the user
        $app['dao.user']->delete($id);
        $app['session']->getFlashBag()->add('success', 'The user was succesfully removed.');
        return $app->redirect('/admin');
    }

    /**
     * @param Request $request
     * @param Application $app
     * @param null $playerId
     * @param null $roundId
     * @return mixed
     */
    public function addLadderResultAction(Request $request, Application $app, $playerId = null, $roundId = null)
    {
        $result = new Result();
        // find round of result
        if (null != $roundId) {
            $round = $app['dao.round']->find($roundId);
            $result->setRound($round);
        }

        // find player of result
        if (null != $playerId) {
            $player = $app['dao.player']->find($playerId);
            $result->setPlayer($player);

        }

        //construct title
        if (null != $playerId && null != $roundId) {

            $title = 'result for ' . $player->getNickname() . ' in ' . $round->getTitle();
        } else {
            $title = 'new result';
        }

        $resultForm = $app['form.factory']->create(new ResultLadderType(), $result);
        $resultForm->handleRequest($request);
        if ($resultForm->isSubmitted() && $resultForm->isValid()) {
            $reponse = $app['dao.result']->save($result);
            $app['session']->getFlashBag()->add('success', $reponse);
        }
        return $app['twig']->render('/admin/ladder_result_form.html.twig', array(
            'title' => $title,
            'round' => $round,
            'resultForm' => $resultForm->createView()));
    }

    public function deleteResultAction($resultId, $roundId, Application $app)
    {
        // Delete all associated comments

        // Delete the user
        $app['dao.result']->delete($resultId);
        $app['session']->getFlashBag()->add('success', 'The result was succesfully removed.');
        return $app->redirect('/admin/round/' . $roundId);
    }

    /**
     * Add article controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addLadderPlayerAction(Request $request, Application $app, $roundId)
    {
        $player = new Player();
        $playerForm = $app['form.factory']->create(new PlayerType(), $player);
        $playerForm->handleRequest($request);

        $message = null;

        if ($playerForm->isSubmitted() && $playerForm->isValid()) {

            $reponseEmail = $app['dao.player']->findByEmail($player->getEmail()); // Test to find email
            $reponseNickname = $app['dao.player']->findByNickname($player->getNickname());


            if ($reponseEmail == 'not found' && $reponseNickname == 'not found') { // if is not finded suscrib the new player

                $styleMessage = 'success';
                $message = 'Nex Player Added ';
                $app['dao.player']->save($player);

            } else { // if is finded not suscrib and launch a message
                $styleMessage = 'danger';

                if ($reponseNickname != 'not found') {
                    $message = $message . ' Nickname ' . $player->getNickname() . ', ';
                }
                if ($reponseEmail != 'not found') {
                    $message = $message . ' Email ' . $player->getEmail() . ', ';
                }
                $message = $message . ' already defined ';
            }

            $app['session']->getFlashBag()->add($styleMessage, $message);

        }

        $round = $app['dao.round']->find($roundId);

        return $app['twig']->render('/admin/player_form.html.twig', array(
            'title' => 'New player',
            'playerForm' => $playerForm->createView(),
            'round' => $round,

        ));
    }

    /**
     * Edit comment controller.
     *
     * @param integer $id Comment id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editLadderPlayerAction($id, $roundId, Request $request, Application $app)
    {
        $player = $app['dao.player']->find($id);
        $playerForm = $app['form.factory']->create(new PlayerType(), $player);
        $playerForm->handleRequest($request);
        if ($playerForm->isSubmitted() && $playerForm->isValid()) {
            $app['dao.player']->save($player);
            $app['session']->getFlashBag()->add('success', 'The player was succesfully updated.');
        }

        $round = $app['dao.round']->find($roundId);

        return $app['twig']->render('/admin/player_form.html.twig', array(
            'title' => 'Edit player',
            'round' => $round,
            'playerForm' => $playerForm->createView()));
    }

    /**
     * Edit comment controller.
     *
     * @param integer $resultId Comment id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editLadderResultAction($resultId, Request $request, Application $app)
    {

        $result = $app['dao.result']->find($resultId);

        $resultForm = $app['form.factory']->create(new ResultLadderType(), $result);
        $resultForm->handleRequest($request);
        if ($resultForm->isSubmitted() && $resultForm->isValid()) {
            $app['dao.result']->edit($result);
            $app['session']->getFlashBag()->add('success', 'The result was succesfully updated.');
        }


        $round = $result->getRound();

        return $app['twig']->render('/admin/ladder_result_form.html.twig', array(
            'title' => 'Edit Result',
            'round' => $round,
            'resultForm' => $resultForm->createView()));
    }

    /**
     * @param $playerId
     * @param $roundId
     * @return mixed
     */
    public function deletePlayerAction($playerId, $roundId, Application $app)
    {
        // Delete the user
        $app['dao.player']->delete($playerId);
        $app['session']->getFlashBag()->add('success', 'The player was succesfully removed.');
        return $app->redirect('/admin/round/' . $roundId);
    }

}