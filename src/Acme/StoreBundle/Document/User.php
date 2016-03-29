<?php
/**
 * Created by PhpStorm.
 * User: Gess
 * Date: 18/03/2016
 * Time: 09:24
 */

namespace Acme\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use FOS\UserBundle\Model\User as BaseUser;


/**
 * @ODM\Document(repositoryClass="Acme\StoreBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ODM\Id(strategy="auto")
     */
    protected $id;

    /**
     * @ODM\EmbedMany(targetDocument="PlayerInfo")
     */
    protected $playerInfos;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->enabled = true;
        $this->playerInfos = array();
    }

    /**
     * Get id
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return PlayerInfo PlayerInfo
     */
    public function getPlayerInfos()
    {
        return $this->playerInfos;
    }

    /**
     * @param mixed $playerInfo
     */
    public function addPlayerInfos(PlayerInfo $playerInfo)
    {
        $this->playerInfos[] = $playerInfo;
    }

}
