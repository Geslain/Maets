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
 * @ODM\Document
 */
class Game
{
    /**
     * @ODM\Id(strategy="auto")
     */
    protected $id;

    /**
     * @var
     * @ODM\Field(type="string")
     */
    protected $name;

    /**
     * @ODM\Field(type="collection")
     */
    protected $badges;

    /**
     * Game constructor.
     */
    function __construct()
    {
        $this->badges = array();
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
