 <?php

	require("auth.php");
	$authkey = zabbixLogin()->result;
	print_r($authkey);

	/* Add query in here */

	$z_trigger_arr = array (
		"jsonrpc" => "2.0",
		"method" => "alert.get",
		"params" => array (
			"output" => "extend",
			"limit" => 10,
			"sortfield": "clock",
			"sortorder": "DESC",
			),
		"auth" => $authkey, 
		"id" => 1
		);
	$z_trigger_json = json_encode($z_trigger_arr);
	print("<br><br>");
	print_r($z_trigger_json);
	$z_results = curlWrap($z_trigger_json);
	print("<br><br>");
	$z_results_json = json_encode($z_results);
	print_r($z_results_json);

	/* End query here */

	$logout_result = zabbixLogout($authkey);
	print("<br><br>");
	print_r($logout_result);
?>