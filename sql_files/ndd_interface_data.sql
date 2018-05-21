ALTER TABLE `ndd_interface_data` ADD `ospf_cost` INT(10) NOT NULL AFTER `eth_trunk`, ADD `ospf_network_type` VARCHAR(50) NULL DEFAULT NULL AFTER `ospf_cost`, ADD `ip_address` VARCHAR(50) NULL DEFAULT NULL AFTER `ospf_network_type`;

ALTER TABLE `ndd_interface_data` ADD `l2_binding_vsi` VARCHAR(100) NULL DEFAULT NULL AFTER `ip_address`; 

ALTER TABLE `ndd_interface_data` ADD `shutdown_status` VARCHAR(50) NULL DEFAULT NULL AFTER `l2_binding_vsi`; 

ALTER TABLE `ndd_interface_data` ADD `ospf_time_hello` INT(10) NOT NULL AFTER `ospf_network_type`, ADD `ospf_time_dead` INT(10) NOT NULL AFTER `ospf_time_hello`; 
