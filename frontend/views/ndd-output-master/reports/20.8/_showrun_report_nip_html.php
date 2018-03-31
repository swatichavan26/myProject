<p>Hostname <?php echo $model->hostname ?></p>
<p>ip ftp source-interface <?php echo $model->loopback0_ipv4 ?></p>
<p>ip ftp username <usernamre></p><p>service tcp-keepalives-in</p>
<p>service tcp-keepalives-out</p>
<p>service timestamps debug datetime msec</p>
<p>service timestamps log datetime msec localtime</p>
<p>service password-encryption</p>
<p>logging buffered 2000000</p>
<p>logging host <?php echo $model->loopback0_ipv4 ?></p>
<p>logging userinfo</p>
<p>logging source-interface <?php echo $model->loopback0_ipv4 ?></p>
<p>logging alarm informational</p>
<p>no logging console</p>
<p>ip ftp password <password></p>
<p>!</p>
<p>ip name-server <IP ADDRESS>  <IP ADDRESS> </p>
<p>ip domain lookup source-interface Loopback<X></p>
<p>ip domain name < name, ex: ce.local ></p>
<p>!</p>
<p>network-clock revertive </p>
<p>network-clock synchronization automatic</p>
<p>network-clock synchronization mode QL-enabled</p>
<p>! </p>
<p>!</p>
<p>network-clock input-source 10 interface <Ten>GigabitEthernet0/<SLOT>/<PORT></p>
<p>network-clock input-source 20 interface <Ten>GigabitEthernet0/<SLOT>/<PORT></p>
<p>! </p>
<p>network-clock wait-to-restore 300 global</p>
<p>network-clock log ql-changes</p>
<p>esmc process</p>
<p>policy-map < police name ex:10M ></p>
<p>class class-default</p>
<p>police cir 10000000 bc 937500 be 15000000</p>
<p>!</p>
<p>policy-map < police name ex:100M></p>
<p>class class-default</p>
<p>police cir 100000000 bc 125000</p>
<p>!</p>
<p>policy-map < police name ex:300M></p>
<p>class class-default</p>
<p>police cir 300000000 bc 1875000</p>
<p>!</p>
<p>policy-map < police name ex:150M></p>
<p>class class-default</p>
<p>police cir 150000000 bc 937500</p>
<p>!</p>
<p>policy-map < police name ex: 600M ></p>
<p>class class-default</p>
<p>police cir 600000000 bc 3750000</p>
<p>!</p>
<p>!</p>
<p>aaa new-model</p>
<p>!</p>
<p>aaa group server tacacs+ OPTUS-TACACS</p>
<p>server 10.194.228.68</p>
<p>server 10.194.227.68</p>
<p>ip tacacs source-interface Loopback1</p>
<p>!</p>
<p>aaa authentication login VTY-TACACS group OPTUS-TACACS local</p>
<p>aaa authentication login CONSOLE group OPTUS-TACACS enable local</p>
<p>aaa authentication enable default group OPTUS-TACACS enable</p>
<p>aaa authorization exec default group OPTUS-TACACS local</p>
<p>aaa authorization commands 1 default group OPTUS-TACACS local</p>
<p>aaa authorization commands 15 default group OPTUS-TACACS local</p>
<p>aaa accounting exec default start-stop group OPTUS-TACACS</p>
<p>aaa accounting commands 15 default start-stop group OPTUS-TACACS</p>
<p>!</p>
<p>!</p>
<p>aaa session-id common</p>
<p>!</p>
<p>tacacs-server administration</p>
<p>tacacs-server host 10.194.228.68</p>
<p>tacacs-server host 10.194.227.68</p>
<p>tacacs-server timeout 3</p>
<p>tacacs-server key <KEY></p>
<p>ip tacacs source-interface Loopback<NUMBER></p>
<p>!</p>
<p>username < username > privilege 15 secret <password></p>
<p>!</p>
<p>ip ftp source-interface Loopback< X ></p>
<p>ip ftp username < username ></p>
<p>ip ftp password 0 < password ></p>
<p>!</p>
<p>mpls label protocol ldp</p>
<p>mpls ldp nsr</p>
<p>mpls ldp graceful-restart</p>
<p>mpls ldp session protection</p>
<p>mpls ldp igp sync holddown 60000</p>
<p>mpls ldp discovery targeted-hello accept</p>
<p>mpls ldp sync</p>
<p>mpls ldp router-id Loopback< X > force</p>
<p>!</p>
<p>mpls ldp neighbor < ip neighbour > targeted ldp</p>

<!--<p>!!!! Example of configuration</p>-->

<p>interface GigabitEthernet1/2/3</p>
<p>description 22SM_S2WE_EBC001_VNX_CO1462267</p>
<p>no ip address</p>
<p>no shutdown</p>
<p>!</p>
<p>l2 vfi CPE_Management_22SM_2NHW  manual</p>
<p>vpn id 4392</p>
<p>bridge-domain 4088</p>
<p>neighbor 10.115.32.2  encapsulation mpls</p>
<p>neighbor 10.115.32.2  encapsulation mpls</p>
<p>!</p>
<p>service instance 2 ethernet</p>
<p>description 22SM_S2WE_EBC001_VNX_CO1462267</p>
<p>encapsulation dot1q  4088</p>
<p>rewrite ingress tag pop 1 symmetric</p>
<p>bridge-domain 4088</p>
<p>!</p>

<p>!</p>
<p>l2 vfi < VFI NAME > manual</p>
<p>vpn id < ID ></p>
<p>bridge-domain < ID ></p>
<p>neighbor < IP NEIGHBOR > encapsulation mpls</p>
<p>neighbor < IP NEIGHBOR > encapsulation mpls</p>
<p>neighbor < IP NEIGHBOR > encapsulation mpls</p>
<p>bridge-domain < bd-id></p>
<p>!</p>
<p>service instance < si-id > ethernet</p>
<p>description <DESCRIPTION></p>
<p>encapsulation dot1q  < vlan  > second-dot1q < vlan ></p>
<p>rewrite ingress tag pop 1 symmetric</p>
<p>bridge-domain < bd-id ></p>
<p>!</p>

<!--<p>------------------------------------------------------------</p>-->
<p>!</p>
<p>interface BDI< XX ></p>
<p>description < DESCRIPTION ></p>
<p>ip address <IP ADDRESS> <NETWORK MASK></p>
<p>ip ospf cost 1000</p>
<p>ip ospf network point-to-point</p>
<p>ip ospf 1 area <AREA_ID></p>
<p>mpls ldp igp sync delay 60</p>
<p>mtu 9198</p>
<p>mpls ip</p>
<p>bfd interval 200 min_rx 200 multiplier 3</p>
<p>no bfd echo</p>
<p>!</p>
<p>Inter port-channel < X ></p>
<p>lacp max-bundle 1</p>
<p>!</p>
<p>service instance < id > ethernet</p>
<p>description EFP for LACP packets</p>
<p>encapsulation untagged</p>
<p>l2protocol peer</p>
<p>bridge-domain < bd id ></p>
<p>!</p>
<p>service instance 11 ethernet</p>
<p>encapsulation dot1q < vlan ></p>
<p>rewrite ingress tag pop 1 symmetric</p>
<p>bridge-domain < bd id ></p>
<p>!</p>
<!--<p>-----------------------------------------------</p>-->
<p>!</p>
<p>interface GigabitEthernet< X/X/X ></p>
<p>description < DESCRIPTION ></p>
<p>no shutdown</p>
<p>load-interval 30</p>
<p>synchronous mode</p>
<p>!</p>
<!--<p>----------------------------------------------------------</p>-->
<p>!</p>
<p>line con 0</p>
<p>exec-timeout 549 0</p>
<p>privilege level 15</p>
<p>login authentication CONSOLE</p>
<p>stopbits 1</p>
<p>line aux 0</p>
<p>login authentication CONSOLE</p>
<p>no exec</p>
<p>stopbits 1</p>
<p>line vty 0 4</p>
<p>access-class 10 in</p>
<p>exec-timeout 549 0</p>
<p>login authentication VTY-TACACS</p>
<p>transport input ssh</p>
<p>transport output ssh</p>
<p>line vty 5 100</p>
<p>access-class 10 in</p>
<p>exec-timeout 549 0</p>
<p>login authentication VTY-TACACS</p>
<p>transport input ssh</p>
<p>transport output ssh</p>
<p>!</p>
<!--<p>-----------------------------------------</p>-->







