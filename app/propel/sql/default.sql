
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- User
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `User`;

CREATE TABLE `User`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_email` VARCHAR(100) NOT NULL,
    `username` VARCHAR(100) NOT NULL,
    `user_firstname` VARCHAR(100) NOT NULL,
    `user_lastname` VARCHAR(100) NOT NULL,
    `password` VARCHAR(128) NOT NULL,
    `salt` INTEGER NOT NULL,
    `phone_number` INTEGER NOT NULL,
    `supervisor_quota_1` INTEGER DEFAULT 0,
    `role_id` INTEGER,
    `status` VARCHAR(50) NOT NULL,
    `project_year` VARCHAR(4) NOT NULL,
    `department` VARCHAR(50) NOT NULL,
    `created_by` INTEGER,
    `created_on` DATETIME,
    `modified_by` INTEGER,
    `modified_on` DATETIME,
    `supervisor_quota_2` INTEGER DEFAULT 0,
    `quota_used_1` INTEGER DEFAULT 0,
    `quota_used_2` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`,`user_email`),
    INDEX `User_FI_1` (`role_id`),
    CONSTRAINT `User_FK_1`
        FOREIGN KEY (`role_id`)
        REFERENCES `Role` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- Role
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `Role`;

CREATE TABLE `Role`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `description` VARCHAR(50) NOT NULL,
    `status` VARCHAR(50) NOT NULL,
    `valid_from` DATETIME,
    `valid_until` DATETIME,
    `created_by` INTEGER,
    `created_on` DATETIME,
    `modified_by` INTEGER,
    `modified_on` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- Profile
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `Profile`;

CREATE TABLE `Profile`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `description` VARCHAR(50) NOT NULL,
    `created_by` INTEGER,
    `created_on` DATETIME,
    `modified_by` INTEGER,
    `modified_on` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- ProfileUser
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ProfileUser`;

CREATE TABLE `ProfileUser`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `profile_id` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `start_date` DATETIME NOT NULL,
    `end_date` DATETIME NOT NULL,
    `created_by` INTEGER,
    `created_on` DATETIME,
    `modified_by` INTEGER,
    `modified_on` DATETIME,
    PRIMARY KEY (`id`,`profile_id`,`user_id`),
    INDEX `ProfileUser_FI_1` (`user_id`),
    INDEX `ProfileUser_FI_2` (`profile_id`),
    CONSTRAINT `ProfileUser_FK_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `User` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `ProfileUser_FK_2`
        FOREIGN KEY (`profile_id`)
        REFERENCES `Profile` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- Project
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `Project`;

CREATE TABLE `Project`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `supervisor_id` INTEGER NOT NULL,
    `physical_copy_submitted` TINYINT DEFAULT 0,
    `alternate_email_id` INTEGER,
    `title` VARCHAR(100) NOT NULL,
    `problem_statement` TEXT NOT NULL,
    `supervisor_comments` TEXT NOT NULL,
    `status` VARCHAR(50) NOT NULL,
    `second_marker_id` INTEGER DEFAULT 0,
    `third_marker_id` INTEGER DEFAULT 0,
    `created_by` INTEGER,
    `created_on` DATETIME,
    `modified_by` INTEGER,
    `modified_on` DATETIME,
    PRIMARY KEY (`id`,`user_id`),
    INDEX `Project_FI_1` (`user_id`),
    CONSTRAINT `Project_FK_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `User` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- Email
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `Email`;

CREATE TABLE `Email`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `project_id` INTEGER NOT NULL,
    `from` VARCHAR(100) NOT NULL,
    `to` VARCHAR(100) NOT NULL,
    `subject` VARCHAR(100) NOT NULL,
    `body` VARCHAR(100) NOT NULL,
    `sent_date` DATETIME,
    `resent_count` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`,`user_id`,`project_id`),
    INDEX `Email_FI_1` (`user_id`),
    INDEX `Email_FI_2` (`project_id`),
    CONSTRAINT `Email_FK_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `User` (`id`),
    CONSTRAINT `Email_FK_2`
        FOREIGN KEY (`project_id`)
        REFERENCES `Project` (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- ProjectMark
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ProjectMark`;

CREATE TABLE `ProjectMark`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `evaluator_id` INTEGER NOT NULL,
    `project_id` INTEGER NOT NULL,
    `total_marks` INTEGER NOT NULL,
    `mark_1` INTEGER NOT NULL,
    `mark_2` INTEGER NOT NULL,
    `created_by` INTEGER,
    `created_on` DATETIME,
    `modified_by` INTEGER,
    `modified_on` DATETIME,
    PRIMARY KEY (`id`,`user_id`,`evaluator_id`,`project_id`),
    INDEX `ProjectMark_FI_1` (`user_id`),
    INDEX `ProjectMark_FI_2` (`project_id`),
    INDEX `ProjectMark_FI_3` (`evaluator_id`),
    CONSTRAINT `ProjectMark_FK_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `User` (`id`),
    CONSTRAINT `ProjectMark_FK_2`
        FOREIGN KEY (`project_id`)
        REFERENCES `Project` (`id`),
    CONSTRAINT `ProjectMark_FK_3`
        FOREIGN KEY (`evaluator_id`)
        REFERENCES `User` (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- ProjectDocument
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ProjectDocument`;

CREATE TABLE `ProjectDocument`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `project_id` INTEGER NOT NULL,
    `version` VARCHAR(20) NOT NULL,
    `type` VARCHAR(20) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `status` VARCHAR(50) NOT NULL,
    `document` VARCHAR(100) NOT NULL,
    `created_by` INTEGER,
    `created_on` DATETIME,
    `modified_by` INTEGER,
    `modified_on` DATETIME,
    PRIMARY KEY (`id`,`user_id`,`project_id`),
    INDEX `ProjectDocument_FI_1` (`user_id`),
    INDEX `ProjectDocument_FI_2` (`project_id`),
    CONSTRAINT `ProjectDocument_FK_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `User` (`id`),
    CONSTRAINT `ProjectDocument_FK_2`
        FOREIGN KEY (`project_id`)
        REFERENCES `Project` (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- Register
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `Register`;

CREATE TABLE `Register`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- AppStatus
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `AppStatus`;

CREATE TABLE `AppStatus`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `active_from` DATETIME,
    `active_untill` DATETIME,
    `modified_by` INTEGER,
    `modified_on` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
