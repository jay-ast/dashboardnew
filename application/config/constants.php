<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

//Error Reporting Globals
define('SITE_TITLE', 'Perfect Forms App');
define('SITE_NAME', 'http://admin.perfectforms-pt.com/');
define('SITE_MAIL_TITLE', 'Perfect Forms');
define('APP_ITUNES_LINK', 'https://apps.apple.com/us/app/perfect-forms/id1091152200');
define('APP_PLAYSTORE_LINK', 'https://play.google.com/store/apps/details?id=com.perfectform');
define('APP_WEBAPP_LINK', 'https://webapp.perfect-forms.net');
define('SUPPORT_LINK', 'http://support.perfect-forms.net');
define('SITE_EMAIL', 'info@perfectforms-pt.com');
define('FROM_MAIL', 'support@perfect-forms.net');

// define('ERROR_REPORT_EMAIL', 'hiren.p@simform.in');
define('ERROR_REPORT_EMAIL', 'developers.shabbir@arsenaltech.com');
/* End of file constants.php */
/* Location: ./application/config/constants.php */