<?php

class Security {
  public $uri = [];
  public $post = [];
  public $get = [];
  public function __construct($args){
    if (isset($args["post"])){
      $this->post = filter_input_array(INPUT_POST, $args["post"]);
    }


    $this->uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
    global $config;
    if ($config["workingFolder"] != "") {
      $this->uri = explode($config["workingFolder"], $this->uri);
      $this->uri = implode("", $this->uri);
    }

    $this->uri = explode("/", $this->uri);
    $this->uri = array_slice($this->uri, 1);
  }
}