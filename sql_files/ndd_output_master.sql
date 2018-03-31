
DROP TABLE IF EXISTS `ndd_output_master`;
CREATE TABLE `ndd_output_master` (
  `id` int(10) NOT NULL,
  `host_name` varchar(30) NOT NULL,
  `loopback0_ipv4` varchar(30) NOT NULL,
  `loopback999_ipv6` varchar(50) NOT NULL,
  `sap_id` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `ndd_output_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `host_name` (`host_name`);

ALTER TABLE `db_optus`.`ndd_output_master` 
CHANGE COLUMN `id` `id` INT(10) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `db_optus`.`ndd_output_master` 
CHANGE COLUMN `sap_id` `sap_id` VARCHAR(30) NOT NULL AFTER `id`,
ADD COLUMN `pdf_done` INT NULL DEFAULT 0 AFTER `loopback999_ipv6`,
ADD COLUMN `pdf_ready` INT NULL DEFAULT 0 AFTER `pdf_done`,
ADD COLUMN `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `pdf_ready`,
ADD COLUMN `created_by` INT(11) NULL AFTER `created_at`,
ADD COLUMN `modified_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_by`,
ADD COLUMN `modified_by` INT(11) NULL AFTER `modified_at`;

ALTER TABLE `db_optus`.`ndd_output_master` 
ADD COLUMN `is_active` INT(11) NULL DEFAULT 1 AFTER `modified_by`;

ALTER TABLE `db_optus`.`ndd_output_master` 
ADD COLUMN `showrun_path` VARCHAR(255) NULL AFTER `loopback999_ipv6`;

ALTER TABLE `db_optus`.`ndd_output_master` 
CHANGE COLUMN `sap_id` `sapid` VARCHAR(30) NOT NULL ,
CHANGE COLUMN `host_name` `hostname` VARCHAR(30) NOT NULL ;


