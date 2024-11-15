CREATE TABLE `catalogue` (
  `id` int UNSIGNED NOT NULL,
  `parent_id` int DEFAULT '0',
  `lft` int DEFAULT '0',
  `rgt` int DEFAULT '0',
  `depth` int DEFAULT '0',
  `order` int DEFAULT '0',
  `follow` int DEFAULT '0',
  `publish` tinyint(1) DEFAULT '1',
  `user_id` int UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `catalogue`
ADD PRIMARY KEY (`id`),
MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;


ALTER TABLE `catalogue`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

ALTER TABLE `catalogue`
  ADD CONSTRAINT `catalogue_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;


CREATE TABLE `catalogue_language` (
  `catalogue_id` int UNSIGNED NOT NULL,
  `language_id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keyword` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `catalogue_language`
  ADD PRIMARY KEY (`catalogue_id`,`language_id`),
  ADD KEY `language_id` (`language_id`);


ALTER TABLE `catalogue_language`
  ADD CONSTRAINT `catalogue_language_ibfk_1` FOREIGN KEY (`catalogue_id`) REFERENCES `catalogue` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `catalogue_language_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;



CREATE TABLE `product` (
  `id` int UNSIGNED NOT NULL,
  `catalogue_id` int UNSIGNED DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `album` text COLLATE utf8mb4_unicode_ci,
  `publish` tinyint(1) DEFAULT '1',
  `follow` tinyint DEFAULT '1',
  `order` int DEFAULT '0',
  `price` DECIMAL(10,2) DEFAULT '0.00',
  `sale` DECIMAL(10,2) DEFAULT '0.00',
  `user_id` int UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_product_catalogue` (`catalogue_id`);


ALTER TABLE `product`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;


ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_catalogue` FOREIGN KEY (`catalogue_id`) REFERENCES `catalogue` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;


CREATE TABLE `product_language` (
  `product_id` int UNSIGNED NOT NULL,
  `language_id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `canonical` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_keyword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `product_language`
  ADD PRIMARY KEY (`product_id`,`language_id`),
  ADD KEY `language_id` (`language_id`);


ALTER TABLE `product_language`
  ADD CONSTRAINT `product_language_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_language_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;




CREATE TABLE `product_catalogue_product` (
  `catalogue_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `product_catalogue_product`
  ADD PRIMARY KEY (`catalogue_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);


ALTER TABLE `product_catalogue_product`
  ADD CONSTRAINT `product_catalogue_product_ibfk_1` FOREIGN KEY (`catalogue_id`) REFERENCES `catalogue` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_catalogue_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;


ALTER TABLE catalogue 
    ADD INDEX idx_parent_id (parent_id), 
    ADD INDEX idx_lft_rgt (lft, rgt);
ALTER TABLE product 
    ADD INDEX idx_catalogue_id (catalogue_id),
    ADD INDEX idx_price_sale (price, sale);
