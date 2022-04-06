<?php

use Phalcon\Mvc\Controller;
use GuzzleHttp\Client;
/**
 * Class to simple use of API
 */
class RandomController extends Controller
{
    public function indexAction()
    {
        $this->view->img=$this->request->getPost('search');
    }
}
