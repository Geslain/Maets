<?php
/**
 * Created by PhpStorm.
 * User: Gess
 * Date: 01/04/2016
 * Time: 00:05
 */

namespace Acme\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;


/**
 * @ODM\EmbeddedDocument
 */
class BadgePlayer
{

    /**
     * @var
     * @ODM\Field(type="string")
     */
    protected $name;

    /**
     * @var
     * @ODM\Field(type="date")
     */
    protected $date;

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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

}