<?php

/**
 * Created by PhpStorm.
 * User: Gess
 * Date: 01/04/2016
 * Time: 01:57
 */
// src/AppBundle/Twig/AppExtension.php
namespace Acme\StoreBundle\Twig;

use Acme\StoreBundle\Document\ScorePlayer;

class AppExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('maxScore', array($this, 'getBestScore')),
        );
    }

    public function getBestScore($scores) {
        $max = 0;
        /** @var ScorePlayer $score */
        foreach($scores as $score) {
            if($max < $score->getValue()) {
                $max = $score->getValue();
            }
        }
        return $max;
    }


    public function getLasttScore($scores) {
        $max = 0;
        /** @var ScorePlayer $score */
        foreach($scores as $score) {
            if($max < $score->getValue()) {
                $max = $score->getValue();
            }
        }
        return $max;
    }


    public function getName()
    {
        return 'app_extension';
    }

}