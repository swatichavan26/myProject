DROP TABLE IF EXISTS `ndd_policy_map_details`;
CREATE TABLE `ndd_policy_map_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `output_master_id` varchar(30) NOT NULL,
  `hostname` varchar(30) NOT NULL,
  `police_name` varchar(30) NOT NULL,
  `cir` varchar(50) NOT NULL,
  `pir` varchar(50) NOT NULL,
  `pbs` varchar(50) NOT NULL,
  `cbs` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `output_master_id` (`output_master_id`),
  KEY `hostname` (`hostname`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;