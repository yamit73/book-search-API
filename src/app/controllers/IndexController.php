<?php

use Phalcon\Mvc\Controller;
use GuzzleHttp\Client;
/**
 * Class to simple use of API
 */
class IndexController extends Controller
{
    /**
     * Book search
     * Api call
     *
     * @return void
     */    
    public function indexAction()
    {
        $bookName = urlencode($this->request->getPost('search'));
        
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://openlibrary.org/',
        ]);
        $response=$client->request('GET', '/search.json?q='.$bookName.'&mode=ebooks&has_fulltext=true');
        $this->view->books=json_decode($response->getBody(), true);
    }
    /**
     * Single book detail
     *
     * @param [type] $id
     * @return void
     */
    public function bookAction($id)
    {
        //URL to hit
        $imgId=$this->request->getQuery('imgId');
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://openlibrary.org/api/'
        ]);
        $response=$client->request('GET', '/books?bibkeys=ISBN:'.$id.'&jscmd=details&format=json');
        //Filtering data before sending to view page
        $key='ISBN:'.$id;
        $book=json_decode($response->getBody(), true)[$key]['details'];

        //Adding extra key as image id recieved from url in data
        $book['img_id']=$imgId;
        $this->view->book=$book;
    }
    public function binAction()
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://httpbin.org/',
            // You can set any number of default request options.
        ]);
        $response=$client->request('GET', '/get');
        echo '<pre>';
        echo($response->getBody());
        die;
    }
}
