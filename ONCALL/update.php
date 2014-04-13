<!DOCTYPE HTML> 
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
<title>On Call Update</title>
</head>
<body> 

<?php

require ('agents.php');
// define variables and set to empty values
$agentErr = NULL;
$agent = NULL;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

   if (isset($_POST["agent"])) {
   	$agent = test_input($_POST["agent"]);
   	$agent_image = $agents_array[$agent]["image"];
    $agent_image_path = "img/".$agent_image;
   	file_put_contents("current.php",$agent_image_path);
   }
   else {
   	$agentErr = "Agent is required";
   }
}

function test_input($data)
{
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
}
?>

<h2>On Call</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   <!-- SELECTOR FOR EACH ON CALL PERSON -->
   <?php 
   	foreach($agents_array as $key => $value) {
   		print("<input type=\"radio\" name=\"agent\" value=\"".$key."\"> ".$agents_array[$key]["name"]."<br>");
   	}
   	?>
   <br><br>
   <input type="submit" name="submit" value="Submit"> 
   <br><br>
   <span class="error"><?php echo $agentErr;?></span>
</form>

</body>
</html>