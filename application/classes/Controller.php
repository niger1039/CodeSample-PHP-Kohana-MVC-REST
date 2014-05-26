<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Controller extends Kohana_Controller
{
    
    protected function output_json($data)
    {
        $this->response->headers('Content-Type','application/json');
        $this->response->body(json_encode($data));
    }
    
}
