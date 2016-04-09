<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 09/03/15
 * Time: 21:13
 */

namespace portfolio\DAO;


class AlloCineAPI
{
    /**
     * @var object
     */
    private $data;

    /**
     * @param $helper from AlloCineAPI
     */
    public function __construct($helper)
    {

        $this->data = $helper;

    }

    /**
     * @param int $count
     * @param int $page
     * @return mixed
     */
    public function getMovieList($count = 1000, $page = 1)
    {
        $movieList = $this->data->movielist($count, $page);

        for ($iKey = 0; $iKey < 1000; $iKey++) { // loops All result

            if (!isset($movieList['movie'][$iKey])) { // test If movies exist else break the loops

                break;
            }
            $movies[] = $movieList['movie'][$iKey];

        }
        return $movies;
    }

    /**
     *Return 4 random Next Movies
     *
     * @return array
     */
    public function getRandomNextMovies()
    {
        $oMovies = $this->data->movielist($count = 20, $page = 1, $filter = array('comingsoon'));
        for ($iPos = 0; $iPos < count($oMovies['movie']); $iPos++) {
            $Movies[] = $oMovies['movie'][$iPos];
        }
        shuffle($Movies);
        for ($iPos = 0; $iPos < 4; $iPos++) {
            $nextMovies[] = $Movies[$iPos];
        }
        return $nextMovies;
    }

    /**
     * return all next Movies
     *
     * @return array
     */
    public function getNextMovies()
    {

        $oMovies = $this->data->movielist($count = 40, $page = 1, $filter = array('comingsoon'));

        for ($iPos = 0; $iPos < count($oMovies['movie']); $iPos++) {

            $Movies[] = $oMovies['movie'][$iPos];
        }
        shuffle($Movies);
        return $Movies;
    }

    public function getMovieByCode($code)
    {

        $this->data->movielist();
        $movie = $this->data->movie($code);

        return $movie;
    }


    /**
     * @param null $search
     * @return mixed
     */
    public function search($search = null)
    {

        $movies = $this->data->search($search, 1, 10);

        if (isset($movies['movie'])) {

            return $movies['movie'];
        }

        return array();

    }

    /**
     * @param $code
     * @return array
     */
    public function getMoviesByGenre($code)
    {
        $genreMovies = array();

        $movies = $this->getMovieList(600, 1); // Load 600 times and load Movies or empty result




        for ($iKey = 0; $iKey < 600; $iKey++) { // loops All result

            for ($iPos = 0; $iPos < count($movies[$iKey]['genre']); $iPos++) { // loop genre to find it

                if ($code == $movies[$iKey]['genre'][$iPos]['code']) {

                    $genreMovies[] = $movies[$iKey]; // if finded loaded on Array();
                }
            }

        }



        return $genreMovies;
    }

    public function getPerson($code = null)
    {

        $this->data->movielist(); //debug
        $person = $this->data->person($code);


        return $person;
    }


} // END CLASS !!!

