<?php

use App\Controllers\Helpers\Date;
use App\Controllers\Helpers\Text;
use App\Models\ArticlesModel;
$slug = new Text;
$date = new Date;

$model = new ArticlesModel;

echo 'findAll()';
$test1 = $model->findAll();
dump($test1);
echo '<br>';

echo 'findBy(2 params => id, author_id)';
$test2 = $model->findBy(['id' => 2, 'author_id' => 1]);
dump($test2);
echo '<br>';

echo 'findBy(1 params => id)';
$test3 = $model->findBy(['id' => 3]);
dump($test3);
echo '<br>';

echo 'find(id)';
$test4 = $model->find(1);
dump($test4);
echo '<br>';

// create
$test5 = $model
    ->setTitle('L\'Article de test 123abc')
    ->setSlug($slug->slugify('L\'Article de test 123abc'))
    ->setContent('Contenu de test')
    ->setCaption('Description courte de test')
    ->setAuthor_id(1)
    ->setUpdated_at($date->getDateNow())
    ->setCreated_at($date->getDateNow());
//$model->create($test5);