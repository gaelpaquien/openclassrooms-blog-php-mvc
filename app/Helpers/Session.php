<?php
namespace App\Helpers;

class Session {
    public $auth;

    public function __construct() {
        $this->auth = &$_SESSION; //this will still trigger a phpmd warning
    }
}