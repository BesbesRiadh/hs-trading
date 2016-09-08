
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- hs_Test
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `hs_Test`;

CREATE TABLE `hs_Test`
(
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(300) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COMMENT='Test';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
