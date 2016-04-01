<?php
/**
 * Created by PhpStorm.
 * User: Gess
 * Date: 29/03/2016
 * Time: 21:10
 */

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Document\BadgePlayer;
use Acme\StoreBundle\Document\Game;
use Acme\StoreBundle\Document\PlayerInfo;
use Acme\StoreBundle\Document\User;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Tests\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\Put;

/**
 * @Route("/stats")
 */
class StatController extends FOSRestController
{

    /**
     * @Route("/{gameName}")
     */
    public function putIndexAction($gameName) {

        $handler = $this->get("request_stack")->getCurrentRequest();
        $data = $handler->request->all();

        $userRepository = $this->get('doctrine_mongodb')->getRepository("AcmeStoreBundle:User");
        $gameRepository = $this->get('doctrine_mongodb')->getRepository("AcmeStoreBundle:Game");

        $userManager = $this->get('fos_user.user_manager');
        $em = $this->get("doctrine.odm.mongodb.document_manager");

        try {
            if(!$user = $userRepository->findOneByUsername($data["player"]))
            {
                $user = $userManager->createUser();
                /** @var User $user */
                $user->setUsername($data["player"]);
                $user->setPlainPassword($data["player"]);
            }

            if (!$game = $gameRepository->findOneByName($gameName)) {
                $game = new Game();
                $game->setName($gameName);
            }

            $gameBadges = $game->getBadges();
            if (!in_array($data["badge"],$gameBadges)) {
                $game->addBadge($data["badge"]);
            }

            if(!$playerInfo = $this->haveGame($user, $game)){
                $playerInfo = new PlayerInfo();
                $playerInfo->setGame($game);

                $badge = new BadgePlayer();
                $badge->setName($data["badge"]);
                $badge->setDate(new \DateTime());
                $playerInfo->addBadge($badge);

                $user->addPlayerInfos($playerInfo);
            } else {
                if (!$this->haveBadge($playerInfo->getBadges(),$data["badge"])) {
                    $badge = new BadgePlayer();
                    $badge->setName($data["badge"]);
                    $badge->setDate(new \DateTime());
                    $playerInfo->addBadge($badge);
                }
            }

            $userManager->updateUser($user);
            $em->persist($game);
            $em->flush();

            $seralizer = SerializerBuilder::create()->build();
            $data = $seralizer->serialize(array($user,$game),"json");
            return new JsonResponse($data);
        } catch ( \Exception $e) {
            $this->get("logger")->error("Erreur", array($e->getMessage(),$e->getCode()));
        }

        return new JsonResponse( array($e->getMessage(),$e->getCode(),$data));
    }

    /**
     * @param User $user
     * @param Game $game
     * @return PlayerInfo|bool
     */
    public function haveGame(User $user,Game $game)
    {
        $playerInfos = $user->getPlayerInfos();
        foreach ($playerInfos as $playerInfo) {
            /** @var PlayerInfo $playerInfo */
            if($playerInfo->getGame()->getId() == $game->getId())
            {
                return $playerInfo;
            }
        }
        return false;
    }

    /**
     * @param $badges
     * @param $badgeName
     * @return bool
     */
    public function haveBadge($badges, $badgeName)
    {
        foreach ($badges as $badge) {
            /** @var BadgePlayer $badge */
            if($badge->getName() == $badgeName)
            {
                return true;
            }
        }
        return false;
    }
}