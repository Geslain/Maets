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
use Acme\StoreBundle\Document\ScorePlayer;
use Acme\StoreBundle\Document\User;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Tests\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\Put;

/**
 * @Route("/scores")
 */
class ScoresController extends FOSRestController
{

    /**
     * @Put("/{gameName}")
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
            

            if(!$playerInfo = $this->haveGame($user, $game)){
                $playerInfo = new PlayerInfo();
                $playerInfo->setGame($game);
            }

            $score = new ScorePlayer();
            $score->setValue($data["score"]);
            $score->setDate(new \DateTime());
            $playerInfo->addScore($score);

            if(!$playerInfo = $this->haveGame($user, $game)) {
                $user->addPlayerInfos($playerInfo);
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
}