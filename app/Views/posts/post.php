<?php
dump($post);
echo '<br>';
echo 'Id : ' . $post->getId() . '<br>';
echo 'Title : ' . $post->getTitle() . '<br>';
echo 'Content : ' . $post->getContent() . '<br>';
?>

<form action="<?= $router->generate('update_article', ['id' => $post->getId()]) ?>" method="POST">
    <input type="text" name="title">
    <button type="submit">Modifier le titre</button>
</form>