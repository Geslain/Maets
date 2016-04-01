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
class ScorePlayer
{

    /**
     * @var
     * @ODM\Field(type="int")
     */
    protected $value;

    /**
     * @var
     * @ODM\Field(type="date")
     */
    protected $date;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
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