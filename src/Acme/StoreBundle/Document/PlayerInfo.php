<?php
/**
 * Created by PhpStorm.
 * User: Gess
 * Date: 29/03/2016
 * Time: 21:21
 */

namespace Acme\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;


/**
 * @ODM\EmbeddedDocument
 */
class PlayerInfo
{
    /**
     * @ODM\ReferenceOne(targetDocument="Game", cascade={"persist"})
     */
    protected $game;

    /**
     * @var
     * @ODM\Field(type="collection")
     */
    protected $scores;

    /**
     * @ODM\Field(type="collection")
     */
    protected $badges;


    /**
     * PlayerInfo constructor.
     */
    function __construct()
    {
        $this->badges = array();
    }

    /**
     * @return mixed
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param mixed $game
     */
    public function setGame($game)
    {
        $this->game = $game;
    }

    /**
     * @return mixed
     */
    public function getScores()
    {
        return $this->scores;
    }

    /**
     * @param mixed $scores
     */
    public function setScores($scores)
    {
        $this->scores = $scores;
    }

    /**
     * @param mixed $score
     */
    public function addScore($score)
    {
        $this->scores[] = $score;
    }


    /**
     * @return mixed
     */
    public function getBadges()
    {
        return $this->badges;
    }

    /**
     * @param mixed $badges
     */
    public function setBadges($badges)
    {
        $this->badges = $badges;
    }

    /**
     * @param mixed $badge
     */
    public function addBadge($badge)
    {
        $this->badges[] = $badge;
    }


}