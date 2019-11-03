<?php


/**
     * Tests the ability to 1) create pub/priv key pair 2) extract pub/priv keys 3) encrypt plaintext using keys 4) decrypt using keys
     * 
     * @return boolean|string False if fails, string if success
     */
    function testOpenSSL($opensslConfigPath = NULL)
    {
        if ($opensslConfigPath == NULL)
        {
            //$opensslConfigPath = "c:\WORK\WT-NMP\conf\openssl.conf";
        }
        $config = array(
            //"config" => $opensslConfigPath,
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );

        $res = openssl_pkey_new($config); // <-- CONFIG ARRAY
        if (empty($res)) {return false;}

        // Extract the private key from $res to $privKey
        openssl_pkey_export($res, $privKey, NULL, $config); // <-- CONFIG ARRAY

        // Extract the public key from $res to $pubKey
        $pubKey = openssl_pkey_get_details($res);
        if ($pubKey === FALSE){return false;}

        $pubKey = $pubKey["key"];

        $data = 'plaintext data goes here';

        // Encrypt the data to $encrypted using the public key
        $res = openssl_public_encrypt($data, $encrypted, $pubKey);
        if ($res === FALSE){return false;}

        // Decrypt the data using the private key and store the results in $decrypted
        $res = openssl_private_decrypt($encrypted, $decrypted, $privKey);
        if ($res === FALSE){return false;}

        return $decrypted;
    }

    // Example usage:
    $res = testOpenSSL();
    if ($res === FALSE)
    {
        echo "<span style='background-color: red;'>Fail</span>";
    } else {
        echo "<span style='background-color: green;'>Pass: ".$res."</span>";
    }



	?>