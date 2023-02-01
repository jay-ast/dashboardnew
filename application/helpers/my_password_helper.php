<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This funstion validates a plain text password with an
 * encrpyted password
 * 
 * @param unknown_type $plain
 * @param unknown_type $encrypted
 * @return boolean
 */
function my_validate_password($plain, $encrypted) {
	if (!is_null($plain) && !is_null($encrypted)) {
		// split apart the hash / salt
		$stack = explode(':', $encrypted);

		if (sizeof($stack) != 2) return ($plain == $encrypted);
		
		if (md5($stack[1] . $plain) == $stack[0]) {
			return true;
		}
	}

	return false;
}

/**
 * This function makes a new password from a plaintext password.\
 * 
 * @param unknown_type $plain
 * @return string
 */
function my_encrypt_password($plain) {
	$password = '';

	for ($i=0; $i<10; $i++) {
		$password .= random_string("numeric", 2);
	}

	$salt = substr(md5($password), 0, 2);

	$password = md5($salt . $plain) . ':' . $salt;

	return $password;
}
?>