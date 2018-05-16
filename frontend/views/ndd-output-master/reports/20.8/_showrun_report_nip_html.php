<?php

use frontend\models\NddInterfaceData; ?>
<p>Hostname <?php echo $model->hostname ?></p>

<p>ip ftp source-interface <?php echo $model->loopback0_ipv4 ?></p>
<p>ip ftp username <usernamre></p>
<p>ip ftp password <password></p>

    <p>service tcp-keepalives-in</p>
    <p>service tcp-keepalives-out</p>
    <p>service timestamps debug datetime msec</p>
    <p>service timestamps log datetime msec localtime</p>
    <p>service password-encryption</p>
    <p>logging buffered 2000000</p>
    <p>logging host <?php echo $model->loghost ?></p>
    <p>logging userinfo</p>
    <p>logging source-interface <?php echo $model->loopback0_ipv4 ?></p>
    <p>logging alarm informational</p>
    <p>no logging console</p>

    <p>!</p>
    <p>ip name-server <?php echo $model->dns_server_1 ?></p>
    <p>ip name-server <?php echo $model->dns_server_1 ?></p>
    <p>ip domain lookup source-interface <?php echo $model->loopback0_ipv4 ?></p>
    <p>ip domain name <?php echo $model->dns_domain_name ?></p>
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

                            <?php
                            if (!empty($policyModel)) {
                                foreach ($policyModel as $key => $policy) {
                                    ?> 
                                    <p>policy-map <?php echo $policy->police_name; ?></p>
                                    <p>class class-default</p>
                                    <p>police cir <?php echo $policy->cir; ?> bc <?php echo $policy->pbs; ?> be <?php echo $policy->pir; ?></p>
                                    <p>!</p>
                                <?php } ?> 
                            <?php } ?>

                            <p>!</p>
                            <p>aaa new-model</p>
                            <p>!</p>
                            <p>aaa group server tacacs+ OPTUS-TACACS</p>
                            <p>server <?php echo $model->tacacs_primary ?></p>
                            <p>server <?php echo $model->tacacs_secondary ?></p>
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
                            <p>tacacs-server host <?php echo $model->tacacs_primary ?></p>
                            <p>tacacs-server host <?php echo $model->tacacs_secondary ?></p>
                            <p>tacacs-server timeout 3</p>
                            <p>tacacs-server key <?php echo $model->tacacs_server_key ?></p>
                            <p>ip tacacs source-interface <?php echo $model->tacacs_source_ip ?></p>
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
                                <p>mpls ldp router-id <?php echo $model->loopback0_ipv4 ?> force</p>
                                <p>!</p>

                                <?php
                                if (!empty($mplsModel)) {
                                    foreach ($mplsModel as $key => $mpls) {
                                        ?> 
                                        <p>mpls ldp neighbor <?php echo $mpls->remote_ip; ?> targeted ldp</p>
                                        <p>!</p>
                                    <?php } ?> 
                                <?php } ?>

                                <?php
                                if (!empty($interfaceModel)) {
                                    foreach ($interfaceModel as $key => $interface) {
                                        ?> 
                                        <p>interface <?php echo $interface->interface; ?></p>
                                        <?php if (!empty($interface->description)) { ?>
                                            <p>description <?php echo $interface->description; ?></p>
                                        <?php } ?>
                                        <?php if (!empty($interface->ip_address)) { ?>
                                            <p>ip address <?php echo $interface->ip_address; ?></p>
                                        <?php } else { ?>   
                                            <p>no ip address</p>
                                        <?php } ?>
                                        <?php if (!empty($interface->ospf_cost)) { ?>
                                            <p>ip ospf cost <?php echo $interface->ospf_cost; ?></p>
                                        <?php } ?>   
                                        <?php if (!empty($interface->ospf_network_type)) { ?>
                                            <p>ip ospf network point-to-point</p>
                                        <?php } ?>   
                                        <p>carrier-delay up msec 50</p>
                                        <p>carrier-delay down msec 0</p>
                                        <?php if (!empty($interface->eth_trunk)) { ?>
                                            <p>channel-group <?php echo $interface->eth_trunk; ?> mode active</p>
                                        <?php } ?>
                                        <p>load-interval 30</p>
                                        <p>service-policy input NNI_INGRESS</p>
                                        <p>service-policy output NNI_EGRESS</p>
                                        <p>synchronous mode</p>
                                        <p>lacp rate fast</p>
                                        <p>no shutdown</p>
                                        <p>!</p>
                                        <?php
                                        //get interface BDI service instance details 
                                        $interfaceObj = new NddInterfaceData();
                                        $interfaceBDIModel = $interfaceObj->getInterfaceBDI($model->id, $interface->interface);
                                        $i = 1;
                                        foreach ($interfaceBDIModel as $interfaceBDI) {
                                            $dot1qArr = explode(',', $interfaceBDI->dot1q_termination);
                                            ?>
                                            <p>service instance <?php echo $i ?> ethernet</p>
                                            <p>description <?php echo $interfaceBDI->description; ?></p>
                                            <p>encapsulation dot1q  <?php
                                                echo $dot1qArr[0];
                                                if (isset($dot1qArr[1])) {
                                                    ?> second-dot1q <?php
                                                    echo $dot1qArr[1];
                                                }
                                                ?></p>
                                            <p>rewrite ingress tag pop 1 symmetric</p>
                                            <p>bridge-domain <?php echo $interfaceBDI->bdi; ?></p>
                                            <p>!</p>

                                            <?php
                                            $i++;
                                        }
                                        ?>

                                    <?php } ?> 
                                <?php } ?>

                                <?php
                                if (!empty($BDIL2Model)) {
                                    $j = 1;
                                    foreach ($BDIL2Model as $key => $BDIL2) {
                                        ?> 
                                        <p>interface BDI<?php echo $BDIL2->bdi; ?></p>
                                        <p>description <?php echo $BDIL2->description; ?></p>
                                        <p>ip address <?php echo $BDIL2->ip_address; ?></p>
                                        <p>ip ospf cost <?php echo $BDIL2->ospf_cost; ?></p>
                                        <?php if (!empty($BDIL2->ospf_network_type)) { ?>
                                            <p>ip ospf network point-to-point </p>
                                        <?php } ?>            
                                        <p>ip ospf 1 area <AREA_ID> </p>
                                            <p>mpls ldp igp sync delay 60 </p>
                                            <p>mtu 9198</p>
                                            <p>mpls ip</p>
                                            <p>bfd interval 200 min_rx 200 multiplier 3</p>
                                            <p>no bfd echo</p>
                                            <p>! </p>
                                            <p>Inter port-channel <?php echo $BDIL2->eth_trunk; ?></p>
                                            <p>description <?php echo $BDIL2->description; ?></p>
                                            <p>lacp max-bundle 1</p>
                                            <p>!</p>
                                            <p>service instance <?php echo $j; ?> ethernet</p>
                                            <p>description EFP for LACP packets</p>
                                            <p>encapsulation untagged</p>
                                            <p>l2protocol peer</p>
                                            <p>bridge-domain <?php echo $BDIL2->eth_trunk; ?></p>
                                            <p>! </p>
                                            <p>service instance <?php echo $j; ?> ethernet</p>
                                            <p>encapsulation dot1q <?php echo $BDIL2->dot1q_termination_vid; ?></p>
                                            <p>rewrite ingress tag pop 1 symmetric</p>
                                            <p>bridge-domain <?php echo $BDIL2->bdi; ?></p>
                                            <p>! </p>

                                            <?php
                                            $j++;
                                        }
                                    }
                                    ?> 

                                    <?php
                                    if (!empty($BDIL3Model)) {
                                        $k = 1;
                                        foreach ($BDIL3Model as $key => $BDIL3) {
                                            ?> 
                                            <p>Inter port-channel <?php echo $BDIL3->eth_trunk; ?></p>
                                            <p>description <?php echo $BDIL3->description; ?></p>
                                            <p>ip address <?php echo $BDIL3->ip_address; ?></p>
                                            <p>ip ospf cost <?php echo $BDIL3->ospf_cost; ?></p>
                                            <?php if (!empty($BDIL3->ospf_network_type)) { ?>
                                                <p>ip ospf network point-to-point </p>
                                            <?php } ?> 
                                            <p>ip ospf 1 area <AREA_ID> </p>
                                                <p>mpls ldp igp sync delay 60 </p>
                                                <p>mtu 9198</p>
                                                <p>mpls ip</p>
                                                <p>bfd interval 200 min_rx 200 multiplier 3</p>
                                                <p>no bfd echo</p>
                                                <p>lacp max-bundle 1</p>
                                                <p>!</p>
                                                <p>service instance <?php echo $k; ?> ethernet</p>
                                                <p>description EFP for LACP packets</p>
                                                <p>encapsulation untagged</p>
                                                <p>l2protocol peer</p>
                                                <p>bridge-domain <?php echo $BDIL3->eth_trunk; ?></p>
                                                <p>! </p>
                                                <p>!</p>
                                                <?php
                                                $k++;
                                            }
                                        }
                                        ?> 


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

                                        <?php //die('Swati')    ?>







