 <?php

 	date_default_timezone_set('America/New_York');

	require("auth.php");
	$authkey = zabbixLogin()->result;
	//print_r($authkey);
	//print("<br><br>");

	/* Add query in here */
	$z_trigger_arr = array (
		"jsonrpc" => "2.0",
		"method" => "history.get",
		"params" => array (
			"output" => "extend",
			"history" => 0,
			"itemids" => "23768",
			"sortfield" => "clock",
			"sortorder" => "DESC",
			"limit" => 60
			),
		"auth" => $authkey, 
		"id" => 1
		);
	/* End query here */

	$z_trigger_json = json_encode($z_trigger_arr);
	//print_r($z_trigger_json);
	//print("<br><br>");

	$z_results = curlWrap($z_trigger_json);
	//print_r($z_results);
	//print("<br><br>");

	//$z_results_json = json_encode($z_results);
	//print_r($z_results_json);
	//print("<br><br>");

	//$logout_result = zabbixLogout($authkey);
	//print_r($logout_result);
	//print("<br><br>");
?>

{
	"graph": {
		"title": "CPU Load",
		"yAxis" : {
			"minValue" : 0,
			"maxValue" : 100
		},
		"refreshEveryNSeconds" : 120,
		"total" : false,
		"type" : "line",
		"datasequences": [
			{
				"title": "ServerName01",
				"color": "purple",
				"datapoints": [
					<?php
						asort($z_results->result);
						foreach ($z_results->result as $cpu) {
							$cpu->value = $cpu->value * 100;
							print("{\"title\": \"".date("H:i",$cpu->clock)."\", \"value\": \"".$cpu->value."\"},");
						}
					?>
				]
			}
		]
	}
}