<?php

use Phalcon\Mvc\Controller;
use PhaSvc\Http\Response as Resp;
class ControllerBase extends Controller
{
    public $response;

    public function initialize(){
        $this->response = new Resp();
    }
}
