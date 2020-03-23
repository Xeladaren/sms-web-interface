drop database if exists `webSMS` ;

CREATE DATABASE IF NOT EXISTS `webSMS` ;

# sms_type = 0 received | 1 = sended
CREATE TABLE IF NOT EXISTS `webSMS`.`sms` (

  `sms_id` int NOT NULL AUTO_INCREMENT,
  `sms_type` tinyint NOT NULL,
  `sms_date` DATETIME DEFAULT NULL,
  `sms_number_type` VARCHAR(3),
  `sms_number` VARCHAR(45),
  `sms_msg` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,

  PRIMARY KEY (`sms_id`)

);

# select * from `webSMS`.`sms`;