CREATE TABLE `taxonomy_post` (
  `taxonomy_id` int(10) unsigned NOT NULL,
  `post_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `taxonomy_post_post_id_taxonomy_id_unique` (`post_id`,`taxonomy_id`),
  KEY `taxonomy_post_taxonomy_id_foreign` (`taxonomy_id`),
  CONSTRAINT `taxonomy_post_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `taxonomy_post_taxonomy_id_foreign` FOREIGN KEY (`taxonomy_id`) REFERENCES `taxonomies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci