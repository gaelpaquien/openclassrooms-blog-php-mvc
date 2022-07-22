<?php

require(dirname(__DIR__) . '/../controllers/post/post.php');

echo 'Id : ' . $post->getId() . '<br>';
echo 'Title : ' . $post->getTitle() . '<br>';
echo 'Content : ' . $post->getContent() . '<br>';
echo '<br>';
?>

<form action="<?= $router->generate('update_article') ?>" method="POST">
    <input type="text" name="title">
    <button type="submit">Modifier le titre</button>
</form>