<?php
namespace App\Helpers;

use Whoops\Run;

class Whoops
{

    private Run $whoops;

    public function __construct()
    {
        $this->whoops = new Run();
        $this->whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    }

    public function run(): self
    {
        $this->whoops->register();
        return $this;
    }
    
}
