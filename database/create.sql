drop database if exists `webSMS` ;
CREATE DATABASE IF NOT EXISTS `webSMS` ;

ALTER DATABASE webSMS CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

# sms_type = 0 received | 1 = sended
CREATE TABLE IF NOT EXISTS webSMS.sms (

  `sms_id` int NOT NULL AUTO_INCREMENT,
  `sms_type` tinyint not null, # 0 = received | 1 = sended
  `sms_status` tinyint default 0, # received = | 0 -> unread, 1 -> read | sended = | 0 = wait for send, 1 -> sended |
  `sms_date` DATETIME DEFAULT NULL, # UTC datetime
  `sms_number_type` VARCHAR(3),
  `sms_number` VARCHAR(45),
  `sms_msg` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,

  PRIMARY KEY (`sms_id`)

);

ALTER TABLE webSMS.sms CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# select * from `webSMS`.`sms`;