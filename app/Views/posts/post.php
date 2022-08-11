<form action="<?= $router->url('update_article', ['id' => $post->getId()]) ?>" method="POST">
    <input type="text" name="title">
    <button type="submit">Modifier le titre</button>
</form>
