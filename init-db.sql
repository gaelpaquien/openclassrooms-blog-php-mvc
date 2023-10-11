CREATE DATABASE IF NOT EXISTS `formation_blog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

GRANT ALL PRIVILEGES ON formation_blog.* TO 'admin_gls'@'%';
FLUSH PRIVILEGES;

USE `formation_blog`;

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `slug` varchar(45) NOT NULL,
  `caption` tinytext NOT NULL,
  `content` longtext NOT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `image` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `articles` (`id`, `title`, `slug`, `caption`, `content`, `author_id`, `created_at`, `updated_at`, `image`) VALUES
(64, 'Mon premier article', 'mon-premier-article', 'Ceci est la description courte de mon premier article.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 29, '2022-11-01 00:55:23', '2022-11-01 00:55:23', '01default.jpg'),
(65, 'Mon deuxième article', 'mon-deuxieme-article', 'Ceci est la description courte de mon deuxième article', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 29, '2022-11-02 00:56:56', '2022-11-02 00:56:56', '01default.jpg'),
(66, 'Mon troisième article modifié', 'mon-troisieme-article-modifie', 'Ceci est la description courte modifiée de mon troisième article.', 'Edit : Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 29, '2022-11-03 00:57:30', '2022-11-09 21:20:24', 'mon-troisieme-article.jpeg'),
(67, 'Mon quatrième article modifié', 'mon-quatrieme-article-modifie', 'Ceci est la description courte de mon quatrième article', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 29, '2022-11-04 00:57:58', '2022-11-09 21:20:41', '01default.jpg'),
(68, 'Mon cinquième article', 'mon-cinquieme-article', 'Ceci est la description courte de mon cinquième article.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 29, '2022-11-05 00:58:26', '2022-11-05 00:58:26', 'mon-cinquieme-article.jpeg'),
(69, 'Mon sixième article', 'mon-sixieme-article', 'Ceci est la description courte de mon sixième article.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 29, '2022-11-06 00:58:55', '2022-11-06 00:58:55', 'mon-sixieme-article.jpeg'),
(70, 'Mon septième article', 'mon-septieme-article', 'Ceci est la description courte de mon septième article.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 29, '2022-11-07 00:59:21', '2022-11-07 00:59:21', '01default.jpg'),
(71, 'Mon huitième article', 'mon-huitieme-article', 'Ceci est la description courte de mon huitième article', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 29, '2022-11-08 00:59:50', '2022-11-08 00:59:50', '01default.jpg'),
(72, 'Mon neuvième article', 'mon-neuvieme-article', 'Ceci est la description courte de mon neuvième article', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 29, '2022-11-09 01:00:21', '2022-11-09 01:00:21', 'mon-neuvieme-article.jpeg');

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `validate` tinyint(4) NOT NULL DEFAULT 0,
  `validate_by` int(11) DEFAULT NULL,
  `article_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `comments` (`id`, `author_id`, `content`, `validate`, `validate_by`, `article_id`, `created_at`) VALUES
(165, 31, 'Jolie photo !', 1, 29, 66, '2022-11-07 01:05:49'),
(166, 31, 'Super article !', 1, 29, 71, '2022-11-08 01:06:00'),
(167, 31, 'Le titre est bien choisi :)', 1, 29, 69, '2022-11-09 01:06:24'),
(168, 30, 'Commentaire de test', 1, 29, 68, '2022-11-09 01:12:32'),
(169, 30, 'Commentaire de test', 1, 29, 68, '2022-11-09 01:12:42'),
(171, 30, 'Commentaire de test', 0, NULL, 68, '2022-11-09 01:12:53'),
(172, 30, 'Commentaire de test', 0, NULL, 68, '2022-11-09 01:12:58'),
(173, 30, 'Commentaire de test ', 0, NULL, 68, '2022-11-09 01:13:05'),
(174, 30, 'Commentaire de test', 0, NULL, 68, '2022-11-09 01:13:11'),
(175, 30, 'Commentaire de test', 0, NULL, 68, '2022-11-09 01:13:17'),
(176, 30, 'Commentaire de test ', 0, NULL, 68, '2022-11-09 01:13:26'),
(177, 30, 'Commentaire de test', 0, NULL, 68, '2022-11-09 01:13:31'),
(178, 30, 'Commentaire de test', 0, NULL, 68, '2022-11-09 01:13:38'),
(179, 30, 'Commentaire de test\r\n', 0, NULL, 68, '2022-11-09 01:15:39'),
(180, 30, 'Commentaire de test', 0, NULL, 68, '2022-11-09 01:15:45'),
(181, 30, 'Commentaire de test', 0, NULL, 68, '2022-11-09 01:15:52'),
(182, 30, 'Commentaire de test', 0, NULL, 68, '2022-11-09 01:15:57'),
(183, 30, 'Commentaire de test', 0, NULL, 68, '2022-11-09 01:16:04'),
(184, 30, 'Commentaire de test', 0, NULL, 68, '2022-11-09 01:16:09'),
(185, 30, 'Commentaire de test', 0, NULL, 68, '2022-11-09 01:16:15'),
(186, 30, 'Super article !', 1, 29, 66, '2022-11-08 01:16:30');

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `email` varchar(70) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `subject` varchar(45) NOT NULL,
  `message` longtext NOT NULL,
  `sent_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `contact_messages` (`id`, `email`, `firstname`, `lastname`, `subject`, `message`, `sent_at`) VALUES
(12, 'john.doe@email.com', 'John', 'Doe', 'Sujet du mail de test', 'John Doe (john.doe@email.com)\r\nContenu du mail de test....', '2022-11-09 21:37:43');

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(70) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `email`, `password`, `firstname`, `lastname`, `admin`, `created_at`) VALUES
(29, 'gael.paquien@email.com', '$2y$10$Kpwqar0jwm11l/MYfkB8feiTj44CXN89Z8U0NgaEQTD.rtMeCpkQu', 'Gael', 'Paquien', 1, '2022-11-01 00:53:51'),
(30, 'john.doe@email.com', '$2y$10$Sr.r7C001ecMn/gemaVLh.4xKDz7HLexWPYwhVU39LcbH1HMqX.eS', 'John', 'Doe', 0, '2022-11-02 01:05:15'),
(31, 'sarah.frison@email.com', '$2y$10$Sr.r7C001ecMn/gemaVLh.4xKDz7HLexWPYwhVU39LcbH1HMqX.eS', 'Sarah', 'Frison', 0, '2022-11-03 01:05:15');

ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `title_UNIQUE` (`title`),
  ADD UNIQUE KEY `slug_UNIQUE` (`slug`),
  ADD KEY `fk_article_user_idx` (`author_id`);

ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_comment_author1_idx` (`author_id`),
  ADD KEY `fk_comment_article1_idx` (`article_id`),
  ADD KEY `fk_comment_user1_idx` (`validate_by`);

ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

ALTER TABLE `articles`
  ADD CONSTRAINT `fk_article_user` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comment_article1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `fk_comment_user1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_comment_user2` FOREIGN KEY (`validate_by`) REFERENCES `users` (`id`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;
