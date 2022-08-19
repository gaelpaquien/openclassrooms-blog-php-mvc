<?php
namespace App\Controllers\Helpers;

use Whoops\Run;

class Whoops
{

    private Run $whoops;

    public function __construct()
    {
        $this->whoops = new Run();
        $this->whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    }

    public function run()
    {
        return $this->whoops->register();
    }
    
}
