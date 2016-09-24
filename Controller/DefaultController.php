<?php

namespace Simettric\Gaufrette2LiipImagineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('SimettricGaufrette2LiipImagineBundle:Default:index.html.twig');
    }
}
