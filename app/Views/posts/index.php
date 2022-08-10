<?php
dump($posts);
echo '<br>';

foreach ($posts as $post) {
?>
    <h5><?= $post->getId() . ' - ' . $post->getTitle() ?></h5>
    <p><?= $post->getContent() ?></p>
    <a href="<?= $router->generate('article', ['id' => $post->getId()]) ?>">Voir l'article</a>
    <br><br>
<?php
}