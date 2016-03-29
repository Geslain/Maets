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
class Badge
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
}