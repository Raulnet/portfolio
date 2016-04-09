<?php
/**
 * Created by PhpStorm.
 * User: XVI
 * Date: 08/03/15
 * Time: 11:35
 */

namespace portfolio\Domain;

class Comment
{
    /**
     * Comment id.
     *
     * @var integer
     */
    private $id;

    /**
     * Comment content.
     *
     * @var integer
     */
    private $content;

    /**
     * Associated article.
     *
     * @var \silexMovies\Domain\Article
     */
    private $article;

    /**
     * Comment codeMovie linked
     *
     * @var integer
     */
    private $codeMovie;


    /**
     * Comment author.
     *
     * @var \silexMovies\Domain\User
     */
    private $author;

    /**
     * @var dateTime
     */
    private $date;

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author) {
        $this->author = $author;
    }


    /**
     * @return int
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param $content
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * @return Article
     */
    public function getArticle() {
        return $this->article;
    }

    /**
     * @param Article $article
     */
    public function setArticle(Article $article) {
        $this->article = $article;
    }

    /**
     * @param int $codeMovie
     */
    public function setCodeMovie($codeMovie)
    {
        $this->codeMovie = $codeMovie;
    }

    /**
     * @return int
     */
    public function getCodeMovie()
    {
        return $this->codeMovie;
    }

    /**
     * @param \silexMovies\Domain\dateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return \silexMovies\Domain\dateTime
     */
    public function getDate()
    {
        return $this->date;
    }



}