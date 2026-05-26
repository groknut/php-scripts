CREATE TABLE IF NOT EXISTS `subjects` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `subjects` (`name`) VALUES
('Buisness'),
('Techonology'),
('Advertise'),
('Marketing'),
('Development');

CREATE TABLE IF NOT EXISTS `payments` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `payments` (`name`) VALUES
('WebMoney'),
('Yandex.Money'),
('PayPal'),
('Credit card'),
('Robokassa');

CREATE TABLE IF NOT EXISTS `participants` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `lastname` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `tel` VARCHAR(255) NOT NULL,
  `subject_id` INT(10) UNSIGNED NOT NULL,
  `payment_id` INT(10) UNSIGNED NOT NULL,
  `mailing` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY(`id`),
  INDEX `subject_id` (`subject_id`),
  INDEX `payment_id` (`payment_id`),
  INDEX `deleted_at` (`deleted_at`),
  FOREIGN KEY (`subject_id`) REFERENCES `subjects`(`id`),
  FOREIGN KEY (`payment_id`) REFERENCES `payments`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
