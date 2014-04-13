<?php
//header('Content-type: text/xml');
echo "HERE";
exit;
$conn = mysql_connect("HostIP:3306", "Username", "Password");
if (!$conn) {
echo "Could not connect";
//die('Could not connect: ' . mysql_error());
}
/*
$conn=mysql_connect('HostIP:3306','Username','Password');
$sel=mysql_select_db('DatabaseName');
$query="select host,triggers.description from triggers inner join functions on (functions.triggerid=triggers.triggerid) inner join items on(items.itemid=functions.itemid) inner join hosts on (items.hostid=hosts.hostid) where (triggers.value=1 or (triggers.value=0 and unix_timestamp(now()) -triggers.lastchange < 1800)) and hosts.status=0 and items.status=0";
$result=mysql_query($query);
$counter=0;
$total=mysql_affected_rows();

*/
echo "<?xml version=\"1.0\"?>";
echo "<rss version='2.0'>\n";
echo "<channel>\n";
echo "<title>YourMainTitle</title>\n";
echo "<link>http://zabbix.DOMAIN.com/zabbix</link>\n";
echo "<description>ZabbixTriggers</description>\n";

function rssitem($title,$link,$description){
return;
 echo "<item>\n";
 echo "<title>$title</title>\n";
 echo "<link>$link</link>\n";
 echo "<description>$description</description>\n";
 echo "</item>\n";
}
while($row=mysql_fetch_array($result)){
 $counter++;
 $title="Trigger $counter of $total";
 $description=str_replace('{HOSTNAME}',$row[0],$row[1]);
 $link='http://zabbix.DOMAIN.com/zabbix'; #maybe add direct links to trigger here
 rssitem($title,$link,$description);
}
if($counter==0){
 rssitem('All good','http://zabbix.DOMAIN.com/zabbix','No Triggers are active');
}*/
  echo "</channel>";
  echo "</rss>";
?>