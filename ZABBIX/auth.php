<?php
/*define("ZABBIXAUTHKEY", "Li4thUV5rn89tobaEfaK6AMWG5ru6dVOD0oklReO");*/
define("ZABBIXUSER", "ZabbixStatusBoardUser");
define("ZABBIXPW", "ZabbixPassword");
define("ZABBIXURL", "http://zabbix.DOMAIN.com/zabbix/api_jsonrpc.php");
 
/* Note: do not put a trailing slash at the end of v2 */
 
function curlWrap($json)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
	curl_setopt($ch, CURLOPT_URL, ZABBIXURL);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	
	/*switch($action){
		case "POST":
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
			break;
		case "GET":
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			break;
		case "PUT":
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
			break;
		case "DELETE":
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			break;
		default:
			break;
	}*/

	$output = curl_exec($ch);
	curl_close($ch);
	$decoded = json_decode($output);
	return $decoded;
};

function zabbixLogin() {
	$z_login_arr = array (
		"jsonrpc" => "2.0",
		"method" => "user.login",
		"params" => array(
			"user" => ZABBIXUSER,
			"password" => ZABBIXPW
			),
		"id" => 1
		);
	$z_login_json = json_encode($z_login_arr);
	$z_authkey = curlWrap($z_login_json);
	return $z_authkey;
};

function zabbixLogout($key) {
	$z_logout_arr = array (
		"jsonrpc" => "2.0",
		"method" => "user.logout",
		"params" => array (),
		"id" => 1,
		"auth" => $key
		);
	$z_logout_json = json_encode($z_logout_arr);
	$z_logout_result = curlWrap($z_logout_json);
	return $z_logout_result;
};

?>












