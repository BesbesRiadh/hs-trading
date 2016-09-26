
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- hs_user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `hs_user`;

CREATE TABLE `hs_user`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `firstname` VARCHAR(100) NOT NULL,
    `lastname` VARCHAR(100) NOT NULL,
    `mail` VARCHAR(220) NOT NULL,
    `password` VARCHAR(300),
    `active` TINYINT(1) DEFAULT 0 NOT NULL,
    `roles` TEXT NOT NULL,
    `updated_by` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `UK_mail` (`mail`)
) ENGINE=InnoDB CHARACTER SET='utf8' COMMENT='user';

-- ---------------------------------------------------------------------
-- hs_product
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `hs_product`;

CREATE TABLE `hs_product`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(256),
    `category` VARCHAR(255),
    `description` TEXT,
    `designation` VARCHAR(500),
    `price` VARCHAR(500),
    `img` TEXT,
    `updated_by` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COMMENT='Détails des produits';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
