<?php 
/* Crohn's Kitchen user session
 * author: freezurbern
 * date: Jan 2015
*/

fail('Begin session saving code', '');

// generate an sid
function gen_sid()
{
	$length = '64';
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$string = '';
	for ($i = 0; $i < $length; $i++) {
		$string .= $characters[mt_rand(0, strlen($characters) - 1)];
	}
	return $string;
}

//$test_sid = gen_sid();
//fail('Test sID: '.$test_sid); // output a test.

function grant_session($uid, $username) {

	session_start();
	$_SESSION['uid'] = $uid;
	$_SESSION['user'] = $username;
	$_SESSION['valid'] = 1;
	$_SESSION['super'] = 1;
	$_SESSION['sid'] = gen_sid();
	//fail('Wrote session vars:'.$uid.'|'.$username.'|.');
}

?>