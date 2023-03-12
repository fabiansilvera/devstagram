<?php
        $username = $_POST['username'];
        $password = $_POST['password'];
        $ldap = false;


        $ldapconfig['host'] = 'ldap.forumsys.com';//CHANGE THIS TO THE CORRECT LDAP SERVER
        $ldapconfig['port'] = '389';
        $ldapconfig['basedn'] = 'dc=example,dc=com';//CHANGE THIS TO THE CORRECT BASE DN
        $ldapconfig['usersdn'] = 'cn=scientists';//CHANGE THIS TO THE CORRECT USER OU/CN
        $ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);

        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($ds, LDAP_OPT_NETWORK_TIMEOUT, 10);
        $dn="uid=". $username. "," . $ldapconfig['basedn'];
        //$dn="ou=scientists,dc=example,dc=com";
        if(isset($_POST['username'])){

        try {
            if ($bind=ldap_bind($ds, $dn, $password)) {
                $ldap = true;
            } else {
                return back()->with('mensaje', 'Credenciales Incorrectas');
            }
        } catch (Throwable $e) {
            return back()->with('mensaje', 'Credenciales Incorrectas');
        } 
        }