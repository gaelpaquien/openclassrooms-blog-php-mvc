<h1>Article <?= "Slug : " . $params['slug'] . " Id : " . $params['id'] ?></h1>

<a href="<?= $router->generate('contact') ?>">Nous contacter</a>
<a href="<?= $router->generate('article', ['id' => 60, 'slug' => 'je-suis-le-slug']) ?>">Voir un autre article</a>