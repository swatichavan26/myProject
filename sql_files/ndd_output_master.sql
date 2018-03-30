
DROP TABLE IF EXISTS `ndd_output_master`;
CREATE TABLE `ndd_output_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `host_name` varchar(30) NOT NULL,
  `loopback0_ipv4` varchar(30) NOT NULL,
  `loopback999_ipv6` varchar(50) NOT NULL,
  `sap_id` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `ndd_output_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `host_name` (`host_name`);