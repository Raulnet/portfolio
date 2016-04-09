<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 16/03/2015
 * Time: 10:41
 */

namespace portfolio\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use portfolio\Domain\Comment;
use portfolio\Form\Type\CommentType;

class MovieController {

    /**
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app)
    {

        $articles = $app['dao.article']->findAll();
        $allMovies = $app['alloCine']->getMovieList();
        $movies = $app['paginator']->getDataToPage($allMovies);
        $paginator = $app['paginator']->getPaginator($allMovies);
        $nextMovies = $app['alloCine']->getRandomNextMovies();
        $slider = $app['alloCine']->getNextMovies();

        return $app['twig']->render('/Movie/index.html.twig', array(
            'articles' => $articles,
            'movies' => $movies,
            'nextMovies' => $nextMovies,
            'slider' => $slider,
            'paginator' => $paginator,
        ));
    }

    /**
     * Page controller.
     *
     * @param Application $app Silex application
     *
     * @param $page
     * @return mixed
     */
    public function pageAction(Application $app, $page)
    {

        $articles = $app['dao.article']->findAll();
        $allMovies = $app['alloCine']->getMovieList();
        $movies = $app['paginator']->getDataToPage($allMovies, $page);
        $paginator = $app['paginator']->getPaginator($allMovies, $page);
        $nextMovies = $app['alloCine']->getRandomNextMovies();
        $slider = $app['alloCine']->getNextMovies();

        return $app['twig']->render('/Movie/index.html.twig', array(
            'articles' => $articles,
            'movies' => $movies,
            'nextMovies' => $nextMovies,
            'slider' => $slider,
            'paginator' => $paginator,
        ));
    }

    /**
     * @param Application $app
     * @param int $code
     * @return mixed
     */
    public function pageTestAction(Application $app, $code = 0)
    {
        $slider = $app['alloCine']->getNextMovies();


        return $app['twig']->render('/Movie/movieTest.html.twig', array(

                'slider' => $slider,
            )
        );
    }

    /**
     * @param Application $app
     * @param int $code
     * @param null $genre
     * @param int $page
     * @return mixed
     */
    public function genreAction(Application $app, $code = 0, $genre = null, $page = 1)
    {

        $articles = $app['dao.article']->findAll();
        $allMovies = $app['alloCine']->getMoviesByGenre($code);
        $movies = $app['paginator']->getDataToPage($allMovies, $page);
        $paginator = $app['paginator']->getPaginator($allMovies, $page);
        $nextMovies = $app['alloCine']->getRandomNextMovies();

        return $app['twig']->render('/Movie/index.html.twig', array(
                'articles' => $articles,
                'movies' => $movies,
                'paginator' => $paginator,
                'genre' => $genre,
                'code' => $code,
                'page' => $page,
                'nextMovies' => $nextMovies,
            )
        );
    }

    /**
     * Article details controller.
     *
     * @param integer $id Article id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function articleAction($id, Request $request, Application $app)
    {
        $article = $app['dao.article']->find($id);

        $user = $app['security']->getToken()->getUser();

        $commentFormView = null;
        if ($app['security']->isGranted('IS_AUTHENTICATED_FULLY')) {
            // A user is fully authenticated : he can add comments
            $comment = new Comment();
            $comment->setArticle($article);
            $comment->setAuthor($user);
            $commentForm = $app['form.factory']->create(new CommentType(), $comment);
            $commentForm->handleRequest($request);
            if ($commentForm->isSubmitted() && $commentForm->isValid()) {
                $app['dao.comment']->save($comment);
                $app['session']->getFlashBag()->add('success', 'Your comment was succesfully added.');
            }
            $commentFormView = $commentForm->createView();
        }

        $comments = $app['dao.comment']->findAllByArticle($id);

        return $app['twig']->render('/Movie/article.html.twig', array(
            'article' => $article,
            'comments' => $comments,
            'commentForm' => $commentFormView));
    }


    public function movieAction($code, Request $request, Application $app)
    {

        $movie = $app['alloCine']->getMovieByCode($code);


        $user = $app['security']->getToken()->getUser();
        $commentFormView = null;
        if ($app['security']->isGranted('IS_AUTHENTICATED_FULLY')) {
            // A user is fully authenticated : he can add comments
            $comment = new Comment();
            $comment->setCodeMovie($code);
            $comment->setAuthor($user);
            $commentForm = $app['form.factory']->create(new CommentType(), $comment);
            $commentForm->handleRequest($request);
            if ($commentForm->isSubmitted() && $commentForm->isValid()) {
                $app['dao.comment']->save($comment);
                $app['session']->getFlashBag()->add('success', 'Your comment was succesfully added.');
            }
            $commentFormView = $commentForm->createView();
        }

        $comments = $app['dao.comment']->findAllByMovie($code);
        return $app['twig']->render('/Movie/movie.html.twig', array(
            'movie' => $movie,
            'comments' => $comments,
            'commentForm' => $commentFormView
        ));

    }

    /**
     * @param Application $app
     * @param $code
     * @return mixed
     */
    public function personAction(Application $app, $code){

        $person = $app['alloCine']->getPerson($code);

        return $app['twig']->render('/Movie/person.html.twig', array(
            'person' => $person,
        ));
    }

    /**
     * User login controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function loginAction(Request $request, Application $app)
    {
        return $app['twig']->render('/Movie/login.html.twig', array(
            'error' => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
    }

} 