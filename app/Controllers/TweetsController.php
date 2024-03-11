<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TweetsController extends BaseController
{
    public function retrieveTweets()
    {
        return view('home/home');
    }

    public function addTweet() {
        return view('home/add');
    }
}
