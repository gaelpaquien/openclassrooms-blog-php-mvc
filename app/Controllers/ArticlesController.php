<?php
namespace App\Controllers;

class ArticlesController extends Controller
{
    
    public function show(string $slug, int $id) 
    {
        echo "Je suis la page ArticlesController/show, mon slug est '$slug' et mon id est '$id'";
    }

}
