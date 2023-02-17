<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!function_exists('my_show_message')) {

    function my_show_message($msg = "")
    {
        if ($msg != '') {
            echo '<h4 class="alert_info">' . $msg . '</h4>';
        }
    }
}

if (!function_exists('my_show_error')) {

    function my_show_error($msg = "")
    {
        if ($msg != '') {
            echo '<h4 class="alert_error">' . $msg . '</h4>';
        }
    }
}

if (!function_exists('default_value')) {

    /**
     * function to check variable is null, empty set default value
     * @param (type) pass variable and default value
     * @return (type) Function return variable value
     */
    function default_value($var, $default = '')
    {
        return empty($var) ? $default : $var;
    }
}

if (!function_exists('my_alert_message')) {

    function my_alert_message($class = 'success', $msg = "")
    {
        if ($msg != '' && $class != '') {
            $CI = get_instance();
            $CI->session->set_flashdata('message', array(
                'classname' => $class,
                'data' => $msg
            ));
        }
    }
}
if (!function_exists('my_datenow')) {

    function my_datenow()
    {
        return date('Y-m-d H:i:s');
    }
}

if (!function_exists('my_upload_content')) {

    function my_upload_content($file, $filename = 'avatar', $directory)
    {
        $ci = get_instance();
        if (isset($file[$filename]) && $file[$filename]['tmp_name'] != '') {
            $target_dir = $directory;
            $temp = explode(".", $file[$filename]["name"]);
            $newfilename = random_string('alnum', 25) . '.' . end($temp);
            $target_file = $target_dir . '/' . $newfilename;

            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            if ($file[$filename]["size"] > (20 * 1048576)) {
                $ci->error('Sorry, your file is too large');
            }

            if (move_uploaded_file($file[$filename]["tmp_name"], $target_file)) {
                return $newfilename;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}


if (!function_exists('my_get_format_datetime')) {

    function my_get_format_datetime($time, $timezone = '', $format = 'm/d/Y H:i:s')
    {
        if ($timezone != '') {
            if (substr($timezone, 0, 1) == "+") {
                $timezone = "-" . substr($timezone, 1);
            } elseif (substr($timezone, 0, 1) == "-") {
                $timezone = "+" . substr($timezone, 1);
            }

            return date($format, strtotime($timezone, $time));
        } else {
            return date($format, $time);
        }
    }
}

if (!function_exists('my_get_html_data_from_dbdata')) {

    function my_get_html_data_from_dbdata($str)
    {
        $result = str_replace("\"", '"', $str);
        $result = str_replace("\'", "'", $result);
        $result = str_replace("\n", "<br/>", $result);
        return $result;
    }
}

if (!function_exists('my_get_search_url')) {

    function my_get_search_url($basic_url, $params)
    {
        for ($i = 0; $i < count($params); $i++) {
            if (!isset($_POST[$params[$i]]))
                continue;

            $value = htmlspecialchars($_POST[$params[$i]]);
            if ($value == "")
                continue;

            $basic_url .= ("/" . $params[$i] . "/" . $value);
        }

        return $basic_url;
    }
}

if (!function_exists('my_get_long_length')) {

    function my_get_long_length($latitude, $longitude, $lat_length = 111000)
    {
        $lng_length = abs($lat_length * cos($latitude));

        return $lng_length;
    }
}

if (!function_exists('my_get_length_by_itude')) {

    function my_get_length_by_itude($lat1, $lng1, $lat2, $lng2, $lat_len = 111000)
    {
        $lng_len = my_get_long_length($lat1, $lat2, $lat_len);

        return round(sqrt(pow(($lat2 - $lat1) * $lat_len, 2) + pow(($lng2 - $lng1) * $lng_len, 2)));
    }
}

if (!function_exists('my_get_length_by_itude_mile')) {

    function my_get_length_by_itude_mile($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return round($miles, 1) . " Miles";
    }
}

if (!function_exists('my_get_length_by_itude_mi')) {

    function my_get_length_by_itude_mil($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return round($miles, 1) . " Mi";
    }
}

if (!function_exists('my_get_sql_by_itude')) {

    function my_get_sql_by_itude($v_lat, $v_lng, $f_lat = "latitude", $f_lng = "longitude", $lat_len = 111000)
    {
        //$lng_len = my_get_long_length($v_lat, $v_lng, $lat_len);
        //return "round(sqrt(pow((`".$f_lat."`-".$v_lat.")*".$lat_len.", 2) + pow((`".$f_lng."`-".$v_lng.")*".$lng_len.", 2)))";
        return "( 3959 * acos( cos( radians( $v_lat ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($v_lng ) ) + sin( radians( $v_lat )) * sin( radians( latitude ) ) ) )";
    }
}

if (!function_exists('my_get_username_from_email')) {

    function my_get_username_from_email($email)
    {
        $temp = explode("@", $email);
        return $temp[0];
    }
}

if (!function_exists('my_get_file_url')) {

    function my_get_file_url($image)
    {
        if (strlen($image) == 0)
            return "";

        return WEB_UPLOAD_PATH . $image;
    }
}

//if( ! function_exists('my_get_username_from_email')) {
//	function my_get_username_from_email($email) {
//		$info = explode("@", $email);
//		return $infop[0];
//	}
//}


if (!function_exists('my_email_send')) {

    function my_email_send($toemail, $subject, $email_template, $params, $fromemail = "", $fromname = "")
    {
        $CI = get_instance();
        $to = $toemail;
        $subject = $subject;

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <' . $fromemail . '>' . "\r\n";


        $body = $CI->load->view('emails/' . $email_template, $params, TRUE);

        $result = mail($to, $subject, $body, $headers);


        /*
       
        $body = $CI->load->view('emails/' . $email_template, $params, TRUE);

        $CI->load->library('email');
		$config['protocol'] = "smtp";
        $config['smtp_host'] = "smtp.sendgrid.net";
        $config['smtp_port'] = "587";
        $config['smtp_user'] = "PerfectForms";
        $config['smtp_pass'] = "PF4Video";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['charset'] = "utf-8";

        $CI->email->initialize($config);
        $fromname = FROM_MAIL;
        $CI->email->from($fromemail, $fromname);
        $CI->email->to($toemail);
        $CI->email->reply_to($fromemail);
        $CI->email->subject($subject);
        $CI->email->message($body);
        $result = $CI->email->send();
		$error = $CI->email->print_debugger();
        return $error ;
*/
        return $result;
    }
}

if (!function_exists('my_email_send_error')) {

    function my_email_send_error($toemail, $subject, $error)
    {
        $CI = get_instance();

        $CI->load->library('email');
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "";
        $config['smtp_port'] = "";
        $config['smtp_user'] = "";
        $config['smtp_pass'] = "";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $CI->email->initialize($config);


        $CI->email->from('ronak.k@simform.in', 'Ronak Kotecha');
        $CI->email->to($toemail);
        $CI->email->reply_to("ronak.k@simform.in");
        $CI->email->subject($subject);
        $CI->email->message("$error");
        $result = $CI->email->send();

        return $result;
    }
}

if (!function_exists("my_generator_password")) {

    function my_generator_password($pw_length = 8, $user_en = true, $use_caps = true, $use_numeric = true, $use_specials = true)
    {
        if (!$user_en && !$use_caps && !$use_numeric && !$use_specials) {
            $user_en = true;
        }
        $chars = array();
        $caps = array();
        $numbers = array();
        $num_specials = 0;
        $reg_length = $pw_length;
        $pws = array();
        if ($user_en)
            for ($ch = 97; $ch <= 122; $ch++)
                $chars[] = $ch; // create a-z
        if ($use_caps)
            for ($ca = 65; $ca <= 90; $ca++)
                $caps[] = $ca; // create A-Z
        if ($use_numeric)
            for ($nu = 48; $nu <= 57; $nu++)
                $numbers[] = $nu; // create 0-9
        $all = array_merge($chars, $caps, $numbers);
        if ($use_specials) {
            $reg_length = ceil($pw_length * 0.75);
            $num_specials = $pw_length - $reg_length;
            if ($num_specials > 5)
                $num_specials = 5;
            for ($si = 33; $si <= 47; $si++)
                $signs[] = $si;
            $rs_keys = array_rand($signs, $num_specials);
            foreach ($rs_keys as $rs) {
                $pws[] = chr($signs[$rs]);
            }
        }
        $rand_keys = array_rand($all, $reg_length);
        foreach ($rand_keys as $rand) {
            $pw[] = chr($all[$rand]);
        }
        $compl = array_merge($pw, $pws);
        shuffle($compl);
        return implode('', $compl);
    }
}

if (!function_exists("my_encrypt")) {

    function my_encrypt($data)
    {
        $str = "";
        if (is_array($data)) {
            $str = json_encode($data);
        } else {
            $str = $data;
        }

        $s_key = my_generator_password(16, true, true, true, false);
        $s_vector_iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB), MCRYPT_RAND);

        $en_str = mcrypt_encrypt(MCRYPT_3DES, $s_key, $str, MCRYPT_MODE_ECB, $s_vector_iv);

        $result = base64_encode($en_str);
        //$result = bin2hex($en_str);

        return substr($result, 0, 16) . $s_key . substr($result, 16);
    }
}

if (!function_exists("my_decrypt")) {

    function my_decrypt($data)
    {
        $s_vector_iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB), MCRYPT_RAND);

        $s_key = substr($data, 16, 16);

        $str = substr($data, 0, 16) . substr($data, 32);
        //$de_str = pack("H*", $str);
        $de_str = base64_decode($str);

        return trim(mcrypt_decrypt(MCRYPT_3DES, $s_key, $de_str, MCRYPT_MODE_ECB, $s_vector_iv));
    }
}

if (!function_exists("my_file_get_contents")) {

    function my_file_get_contents($url)
    {
        if (defined("SYSTEM_PROXY_SERVER")) {
            $aContext = array(
                "http" => array("proxty" => "tcp://" . SYSTEM_PROXY_SERVER, "request_fulluri" => true),
            );

            $cxContext = stream_context_create($aContext);
        } else {
            $cxContext = stream_context_create();
        }

        return file_get_contents($url, FALSE, $cxContext);
    }
}


if (!function_exists('my_iphone_push_notification')) {

    function my_iphone_push_notification($devices, $msg, $ext_params = null)
    {
        $CI = &get_instance();
        $CI->load->config("push");

        $config = $CI->config->item("push");
        $config = $config['iphone'];
        $badge_count = 0;
        try {
            require_once APPPATH . 'libraries/ApnsPHP/Autoload.php';

            $apns_message = new ApnsPHP_Message();
            $apns_message->setCustomIdentifier("Message-Badge-3");
            $nCategory = 0;
            $apns_message->setText($msg);

            $apns_message->setSound('Sounds.caf');
            $apns_message->setBadge($badge_count);
            $apns_message->setCategory($nCategory);

            for ($i = 0; $i < count($devices); $i++) {
                $apns_message->addRecipient($devices[$i]);
            }
            if (is_array($ext_params)) {
                foreach ($ext_params as $key => $value) {
                    if ($key == 'category') {
                        $nCategory = $value;
                        $apns_message->setCategory($nCategory);
                    } else {
                        $apns_message->setCustomProperty($key, $value);
                    }
                }
            }


            if ($apns_message->getRecipientsNumber() > 0) {
                $push = new ApnsPHP_Push(
                    $config['push_type'],
                    APPPATH . $config['certfile']
                );
                $push->setRootCertificationPassword($config['certpwd']);
                $push->connect();

                $push->add($apns_message);

                $push->send();
                $push->disconnect();
            }

            return 1;
        } catch (Exception $e) {
            //            
            //            $fp = fopen('./assets/contacts_log/push_error_' . date('d-m-y_H_i_s') . '.txt', 'w');
            //            fwrite($fp, print_r($e, true));
            //            fclose($fp);
            //            return 0;
        }
    }
}

if (!function_exists('my_andoid_push_notification')) {

    function my_andoid_push_notification($devices, $msg, $ext_params = FALSE, $receiver)
    {
        $CI = &get_instance();

        try {
            $CI->load->library("pushAndroid");

            $ext_params["message"] = $msg;

            $CI->pushandroid->send_notification($devices, $ext_params);
        } catch (Exception $e) {
            print_r($e);
        }
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date, $format = "d.m.Y")
    {
        return date($format, strtotime($date));
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime($date, $format = "d.m.Y h:i A")
    {
        return date($format, strtotime($date));
    }
}


if (!function_exists('formatTime')) {
    function formatTime($date, $format = "h:i A")
    {
        return date($format, strtotime($date));
    }
}


if (!function_exists('formatCustomDate')) {
    function formatCustomDate($date, $format = "d.m.Y h:i A")
    {
        return date($format, strtotime($date));
    }
}

if(!function_exists('getAppointmentDates')){
    function getAppointmentDates($date,$repeat,$type){
        $schedule_days = [];        
        for ($i = 0; $i <= $repeat; $i++) {
			$schedule_days[] = date('Y/m/d', strtotime(' +' . $i . $type, strtotime($date)));
		}        
        return $schedule_days;
    }
}
