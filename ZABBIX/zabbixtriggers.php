 <?php

 	$host_array = array(
 		array("name"=>"ServerName01","hostidServerName01"=>"10108","color"=>"purple"),
 		array("name"=>"ServerName02","hostidServerName02"=>"10107","color"=>"yellow"),
 	);

	require("auth.php");
	$authkey = zabbixLogin()->result;
	//print_r($authkey);

	/* Add query in here */

	$z_trigger_arr = array (
		"jsonrpc" => "2.0",
		"method" => "trigger.get",
		"params" => array (
			"output" => "extend",
			"selectHosts" => "extend",
			"filter" => array (
				"value" => 1,
				"status" => 0,
				"state" => 0
				),
			"sortfield" => "priority",
			"sortorder" => "DESC"
			),
		"auth" => $authkey, 
		"id" => 1
		);
	$z_trigger_json = json_encode($z_trigger_arr);
	//print("<br><br>");
	//print_r($z_trigger_json);
	$z_results = curlWrap($z_trigger_json);
	//print("<br><br>");
	//var_dump($z_results);
	$z_results_json = json_encode($z_results);
	//print("<br><br>");
	//print_r($z_results_json);

	/* End query here */

	$logout_result = zabbixLogout($authkey);
	//print("<br><br>");
	//print_r($logout_result);
?>
<table style="font-size:9px">
<tr style="font-size:11px;text-align:center"><td style="width:90px">Severity</td><td style="width:110px">Host</td><td style="text-align:left">Description</td></tr>
<?php
	foreach($z_results->result as $active_trigger){
		$host_object = NULL;
		$host_item = NULL;
		$host_color = NULL;
		$host_name = NULL;
		switch($active_trigger->priority){
			case 1:
				$priority_name = "Information";
				$priority_color = "cdf2ff";
				break;
			case 2:
				$priority_name = "Warning";
				$priority_color = "fbf788";
				break;
			case 3:
				$priority_name = "Average";
				$priority_color = "f7a36c";
				break;
			case 4:
				$priority_name = "High";
				$priority_color = "f67f80";
				break;
			case 5:
				$priority_name = "Disaster";
				$priority_color = "f32023";
				break;
		}

		$host_object = $active_trigger->hosts;
		$host_item = get_object_vars($host_object[0]);

		foreach($host_array as $current_host){
			if ($host_item["hostid"] == $current_host["hostid"]) {
				$host_color = $current_host["color"];
				$host_name = $current_host["name"];
			}
		}
		$current_description = str_replace("{HOST.NAME}",$host_name,$active_trigger->description);
		print("<tr><td style=\"text-align:center;width:90px;color:#666;background-color:#" . $priority_color . "\">".$priority_name."</td><td style=\"text-align:center;width:110px;color:#666;background-color:".$host_color."\">".$host_name."</td><td style=\"text-align:left\">" . $current_description . "</td></tr>");
	};
?>
</table>













