<?php
/**
 * Created by PhpStorm.
 * User: Gess
 * Date: 29/03/2016
 * Time: 21:10
 */

namespace Acme\StoreBundle\Controller;

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
                $userManager->updateUser($user);
            }

            if (!$game = $gameRepository->findOneByName($gameName)) {
                $game = new Game();
                $game->setName($gameName);
            }

            $badges = $game->getBadges();
            if (!in_array($data["badge"],$badges)) {
                $game->addBadge($data["badge"]);
            }

            if(!$playerInfo = $this->haveGame($user, $game)){
                $playerInfo = new PlayerInfo();
                $playerInfo->setGame($game);
                $playerInfo->addBadge($data["badge"]);
                $user->addPlayerInfos($playerInfo);
            } else {
                if (!in_array($data["badge"],$badges)) {
                    $playerInfo->addBadge($data["badge"]);
                }
            }

            $userManager->updateUser($user);
            $em->persist($user);
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
}