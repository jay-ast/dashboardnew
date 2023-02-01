<?php

error_reporting (E_ERROR |E_PARSE  );

ini_set("display_errors", 'on');

$message    = "Hello Test";



$aDeviceToken = array();
/*$aDeviceToken[]   = "81a7b6724460564855b9e9a59382efb4b9d02bfb0e5fca039dc7f74a333926d4";
$aDeviceToken[]   = "daa75616a2f9b2b2c5e8e42fe6236cae031be082a3e3ddf1af6b00d8ad6eec7f";
$aDeviceToken[]   = "f081af4cb55d2c22d9de1556bd2c4c7464619f784360c62243b425ca4ddadde1";
$aDeviceToken[]   = "45dffd478285a32994c5ed589644314e35944193b0b5add1130f385fe1b2dd28";
$aDeviceToken[]   = "9583e650a15c67cbdaa33deaa1b904574e69d7d1b41abeff49b7b2d59580e144";
$aDeviceToken[]   = "1f7cc07ae9a011525dcd30e35099a4d393990428445f0dff4abd31fa35ad87c9";
$aDeviceToken[]   = "73e8296a377a0b55fde154e18f5e0f4a86d578f7ec092b8f5b23d351f781ab3c";
$aDeviceToken[]   = "f62e17ac797857ec3b004ca2111ada583e1c57c7a007908d92f90ac575120d68";
$aDeviceToken[]   = "98d542a59257846a422c9b566184a50643a7115ed2e57d79b028c46283ae042b";
$aDeviceToken[]   = "8e37648efa312a4cefe4d1a25847deca583cb6a7714dee4bfaba6335fcecde0f";
$aDeviceToken[]   = "8868210241825c8d6c64b3ebd9a53486f9c64c5e55d5d530dc3d2947b06edd2c";*/
$aDeviceToken[]   = $_POST['token'];

//echo substr($aDeviceToken, 0, 64)."<br/>";
if (!empty($message)) {
    //Send notification
    //$certFileName = "TungbilFinalck.pem";
    //$certPassword = "fredag11";
    $certFileName = "rehab_Dev.pem";
    $certPassword = "";
    /*
    $certFileName = "usplus(new).pem";

    $certPassword = "";
    */
    //$push_method = "live";//Set it "live" when live on iTunes
    $push_method = "develop";//Set it "live" when live on iTunes
    $messageID = "1";
    
    $runtime = microtime();
    for ($i = 0; $i < count($aDeviceToken); $i ++) {
      $sendResult = send($aDeviceToken[$i], $certFileName, $certPassword, $push_method, $message, 0, "develop", "custom", $messageID);
    }
    echo "Run: ".(microtime() - $runtime);
    echo "<hr>";
    
    
    if ($sendResult) {
      $error_flag = $sendResult;
      $str = "SUCCESS";
    }
    else {
      $error_flag = $sendResult;
      $str = "ERROR";

    }
}

echo $error_flag . "  :  " . $str . " <> " . $message;

function send($deviceToken, $certFile, $certPass, $push_method, $alert, $badge, $sound, $custom_key, $custom_value) 
 { 
  echo $push_method."<hr/>";
 
 //echo $deviceToken."<br/>";
  $deviceToken = str_replace(" ", "", $deviceToken); 
  $deviceToken = pack('H*', $deviceToken);
//    echo $deviceToken = pack('H*', $deviceToken); 
//echo $deviceToken."<br/>";
     $tmp = array(); 
     if($alert) 
     { 
      $tmp['alert'] = $alert; 
     } 
     if($badge) 
     { 
      $tmp['badge'] = $badge; 
     } 
     if($sound) 
     { 
      $tmp['sound'] = $sound; 
     } 
     $tmp['badge'] = 0;
     $body['aps'] = $tmp; 
     //$body[$custom_key] = $custom_value; 
     $ctx = stream_context_create(); 
     stream_context_set_option($ctx, 'ssl', 'local_cert', $certFile); 
     stream_context_set_option($ctx, 'ssl', 'passphrase', $certPass); 
     
     if ( $push_method == 'develop' )
        $ssl_gateway_url = 'ssl://gateway.sandbox.push.apple.com:2195';
     else if ( $push_method == 'live' )
        $ssl_gateway_url = 'ssl://gateway.push.apple.com:2195';
      
     if(isset($certFile) && isset($ssl_gateway_url)) 
     {
        $fp = stream_socket_client($ssl_gateway_url, $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx); 
     }
     if(!$fp) 
     { 
      print "Connection failed $err $errstr\n"; 
      return FALSE; 
     } 
     $payload = json_encode($body); 
     $msg = chr(0).chr(0).chr(32).$deviceToken.chr(0).chr(strlen($payload)).$payload; 
     fwrite($fp, $msg); 

   //  checkAppleErrorResponse($fp);
     fclose($fp);      

     
     return TRUE;
 }



 function checkAppleErrorResponse($fp) {

   //byte1=always 8, byte2=StatusCode, bytes3,4,5,6=identifier(rowID). Should return nothing if OK.
   $apple_error_response = fread($fp, 6);
   //NOTE: Make sure you set stream_set_blocking($fp, 0) or else fread will pause your script and wait forever when there is no response to be sent.

   if ($apple_error_response) {
        //unpack the error response (first byte 'command" should always be 8)
        $error_response = unpack('Ccommand/Cstatus_code/Nidentifier', $apple_error_response);

        if ($error_response['status_code'] == '0') {
            $error_response['status_code'] = '0-No errors encountered';
        } else if ($error_response['status_code'] == '1') {
            $error_response['status_code'] = '1-Processing error';
        } else if ($error_response['status_code'] == '2') {
            $error_response['status_code'] = '2-Missing device token';
        } else if ($error_response['status_code'] == '3') {
            $error_response['status_code'] = '3-Missing topic';
        } else if ($error_response['status_code'] == '4') {
            $error_response['status_code'] = '4-Missing payload';
        } else if ($error_response['status_code'] == '5') {
            $error_response['status_code'] = '5-Invalid token size';
        } else if ($error_response['status_code'] == '6') {
            $error_response['status_code'] = '6-Invalid topic size';
        } else if ($error_response['status_code'] == '7') {
            $error_response['status_code'] = '7-Invalid payload size';
        } else if ($error_response['status_code'] == '8') {
            $error_response['status_code'] = '8-Invalid token';
        } else if ($error_response['status_code'] == '255') {
            $error_response['status_code'] = '255-None (unknown)';
        } else {
            $error_response['status_code'] = $error_response['status_code'] . '-Not listed';
        }

        echo '</br>Response Command:<b>' . $error_response['command'] . '</b>&nbsp;&nbsp;&nbsp;Identifier:<b>' . $error_response['identifier'] . '</b>&nbsp;&nbsp;&nbsp;Status:<b>' . $error_response['status_code'] . '</b><br>';       

        return true;
   }
   return false;
}
?>