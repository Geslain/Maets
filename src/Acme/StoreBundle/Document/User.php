<?php
/**
 * Created by PhpStorm.
 * User: Gess
 * Date: 18/03/2016
 * Time: 09:24
 */

namespace Acme\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use FOS\UserBundle\Model\User as BaseUser;


/**
 * @MongoDB\Document(repositoryClass="Acme\StoreBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->enabled = true;
    }


    /**
     * Get id
     *
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }
}
