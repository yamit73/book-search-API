<?php

use Phalcon\Mvc\Controller;
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
        $url = "https://openlibrary.org/search.json?q=".$bookName."&mode=ebooks&has_fulltext=true";
        
        // Initialize a CURL session.
        $ch = curl_init();

        //grab URL and pass it to the variable.
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $this->view->books=json_decode(curl_exec($ch), true);
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
        $url = "https://openlibrary.org/api/books?bibkeys=ISBN:".$id."&jscmd=details&format=json";
        $imgId=$this->request->getQuery('imgId');
        // Initialize a CURL session.
        $ch = curl_init();

        //grab URL and pass it to the variable.
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //Filtering data before sending to view page
        $key='ISBN:'.$id;
        $book=json_decode(curl_exec($ch), true)[$key]['details'];

        //Adding extra key as image id recieved from url in data
        $book['img_id']=$imgId;
        $this->view->book=$book;
    }
}
