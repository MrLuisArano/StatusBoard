<?php
header('Content-type: ' . 'text/xml');
echo "<?xml version='1.0' encoding='ISO-8859-1' ?>";

<rss version='2.0'>
<channel>
<title>your title</title>
<link>http://www.zabbix.com</link>
<description>Zabbix Triggers</description>

function rssitem($title,$link,$description){
 echo "<item>\n";
 echo "<title>$title</title>\n";
 echo "<link>$link</link>\n";
 echo "<description>$description</description>\n";
 echo "</item>\n";
}

$conn=mysql_connect('HostIP:3306','Username','Password');
$sel=mysql_select_db('DatabaseName');
$query="select host,triggers.description from triggers inner join functions on (functions.triggerid=triggers.triggerid) inner join items on(items.itemid=functions.itemid) inner join hosts on (items.hostid=hosts.hostid) where (triggers.value=1 or (triggers.value=0 and unix_timestamp(now()) -triggers.lastchange < 1800)) and hosts.status=0 and items.status=0";
$result=mysql_query($query);
$counter=0;
$total=mysql_affected_rows();
while($row=mysql_fetch_array($result)){
 $counter++;
 $title="Trigger $counter of $total";
 $description=str_replace('{HOSTNAME}',$row[0],$row[1]);
 $link='http://www.yourzabbixhost.com'; #maybe add direct links to trigger here
 rssitem($title,$link,$description);
}
if($counter==0){
 rssitem('All good','http://www.yourzabbixhost.com/','No Triggers are active');
}
?>
</channel>
</rss>