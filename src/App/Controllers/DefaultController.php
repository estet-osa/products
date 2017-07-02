<?php

namespace App\Controllers;

use \Core\View;

class DefaultController extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {


        View::renderTemplate('Home/index.html.twig');
    }


    public function listAction()
    {
        View::renderTemplate('Home/list.html.twig');
    }
}
