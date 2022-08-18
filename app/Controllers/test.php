<?php

use App\Controllers\Helpers\Date;
use App\Controllers\Helpers\Text;
use App\Models\ArticlesModel;
use App\Models\UsersModel;

$slug = new Text;
$dateClass = new Date;
$date = $dateClass->getDateNow();

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
    ->setAuthor_id(1);
//$model->create($test5);

// hydrate & create
$dataTest6 = [
    'title' => 'Article hydraté 3',
    'slug' => $slug->slugify('Article hydraté 3'),
    'content' => 'Contenu de test 3',
    'caption' => 'Description courte de test 3',
    'author_id' => 1
];
$test6 = $model->hydrate($dataTest6);
//$model->create($test6);

// hydrate & update
$dataTest7 = [
    'title' => 'Article hydraté et modifié',
    'slug' => $slug->slugify('Article hydraté et modifié'),
    'content' => 'Contenu de test modifiié',
    'caption' => 'Description courte de test modifiée',
    'author_id' => 1,
    'updated_at' => $date
];
$test7 = $model->hydrate($dataTest7);
//$model->update(2, $test7);

// delete
//$test8 = $model->delete(16);

$user = new UsersModel;
var_dump($user);