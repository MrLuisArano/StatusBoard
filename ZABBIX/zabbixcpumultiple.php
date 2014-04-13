 {
	"graph": {
		"title": "CPU Load One Minute Average (Past 60 Minutes)",
		"yAxis" : {
			"minValue" : 0,
			"maxValue" : 20,
			"units" : {
				"suffix" : "%"
			}
		},
		"xAxis" : {
			"hide" : false
		},
		"refreshEveryNSeconds" : 120,
		"total" : false,
		"type" : "line",
		"datasequences": [
 <?php

 	date_default_timezone_set('America/New_York');

 	$host_array = array(
 		array("name"=>"ServerName01","hostid"=>"hostidforServerName01","color"=>"purple"),
 		array("name"=>"ServerName02","hostid"=>"hostidforServerName02","color"=>"yellow"),
 	);

 	$results_array = array();

 	$host_count = count($host_array);
 	$host_go = 1;

 	$time_from = time() - 3600;
 	$time_to = time();

	require("auth.php");
	$authkey = zabbixLogin()->result;

	foreach($host_array as $host) {
		/* Add query in here */
		$z_trigger_arr = array (
			"jsonrpc" => "2.0",
			"method" => "history.get",
			"params" => array (
				"output" => "extend",
				"history" => 0,
				"itemids" => $host['hostid'],
				"sortfield" => "clock",
				"sortorder" => "DESC",
				"limit" => 60,
				"time_from" => $time_from,
				"time_to" => $time_to
				),
			"auth" => $authkey, 
			"id" => 1
			);
		/* End query here */

		$z_trigger_json = json_encode($z_trigger_arr);

		$z_results = curlWrap($z_trigger_json);
		$z_results_solo = $z_results->result;

		print("{");
		print("\"title\":\"".$host['name']."\",");
		print("\"color\":\"".$host['color']."\",");
		print("\"datapoints\": [");

		asort($z_results_solo);
		$z_count = count($z_results_solo);
		$z_go = 1;
		foreach ($z_results_solo as $cpu) {
			//$cpu->value = $cpu->value * 100;
			print("{\"title\": \"".date("H:i",$cpu->clock)."\", \"value\": \"".$cpu->value."\"}");
			//print("{\"title\": \"".$cpu->clock."\", \"value\": \"".$cpu->value."\"}");
			// NEED TO PRINT COMMA ONLY IF NOT LAST IN ARRAY
			if ($z_go < $z_count) {
				print(",");
			};
			//
			$z_go++;
		}

		print("]");
		print("}");
		// NEED TO PRINT COMMA ONLY IF NOT LAST IN ARRAY
		if ($host_go < $host_count) {
			print(",");
		};
		//
		$host_go++;
	}

?>
		]
	}
}