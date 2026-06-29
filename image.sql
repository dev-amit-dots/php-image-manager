CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_name` varchar(255) NOT NULL,
  `optimized_image` varchar(255) NOT NULL,
  `watermark_image` varchar(255) NOT NULL,
  `image_size` int(11) NOT NULL COMMENT 'Size in bytes',
  `image_type` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;