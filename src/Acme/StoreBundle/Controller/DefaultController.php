<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Document\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $user = $this->getUser();

        return $this->render('AcmeStoreBundle:default:index.html.twig',array("user"=>$user));
    }

    /**
     * @Route("/players")
     */
    public function viewPlayersAction()
    {
        $userRepository = $this->get('doctrine_mongodb')->getRepository("AcmeStoreBundle:User");
        $users = $userRepository->findAll();

        return $this->render('AcmeStoreBundle:default:players.html.twig',array("users"=>$users));
    }

    /**
     * @Route("/player/{name}")
     */
    public function viewPlayerAction($name)
    {
        $userRepository = $this->get('doctrine_mongodb')->getRepository("AcmeStoreBundle:User");
        $users = $userRepository->findOneByUsername($name);

        return $this->render('AcmeStoreBundle:default:player.html.twig',array("user"=>$users));
    }

    /**
     * @Route("/games")
     */
    public function viewGames()
    {
        $gameRepository = $this->get('doctrine_mongodb')->getRepository("AcmeStoreBundle:Game");
        $games = $gameRepository->findAll();

        return $this->render('AcmeStoreBundle:default:games.html.twig',array("games"=>$games));
    }

    /**
     * @Route("/game/{name}")
     */
    public function viewGame($name)
    {
        $gameRepository = $this->get('doctrine_mongodb')->getRepository("AcmeStoreBundle:Game");
        $game = $gameRepository->findOneByName($name);

        return $this->render('AcmeStoreBundle:default:game.html.twig',array("game"=>$game));
    }
}
