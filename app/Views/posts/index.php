<?php
foreach ($posts as $post) {
?>
    <h5><?= $post->getId() . ' - ' . $post->getTitle() ?></h5>
    <p><?= $post->getContent() ?></p>
    <a href="<?= $router->url('article', ['id' => $post->getId()]); ?>">Voir l'article</a>
    <br><br>
<?php
}
