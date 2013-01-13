<?php

function tweet($message){

//global $RG_addr;
//TWITTER TEST
//require_once $RG_addr["twitter"];
//require 'lib/o_auth/tmhUtilities.php';

if(!_TW_OFF){

    $tmhOAuth = new tmhOAuth(array(
      'consumer_key'    => _TW_CONSUMER_KEY,
      'consumer_secret' => _TW_CONSUMER_SECRET,
      'user_token'      => _TW_USER_TOKEN,
      'user_secret'     => _TW_USER_SECRET,
      'curl_ssl_verifypeer'   => false
    ));

    if(mb_detect_encoding($message, 'UTF-8')<>'UTF-8'){
      $message = utf8_encode($message);  
    }; 


    $code = $tmhOAuth->request('POST', $tmhOAuth->url('1/statuses/update'), 
                                    array(
                                      'status' => $message
                                    )
                                    );

        if ($code == 200) {
          return true;
        } else {
          return false;
        }
    }
    return false;
}