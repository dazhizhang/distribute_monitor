<?php
/*
http://www.w3school.com.cn/php/php_mysql_connect.asp
*/

if (!isset($_GET['account'])) {
	echo "did not set account, return</br>";
	return;
}
if (!isset($_GET['lastupdate'])) {
	echo "did not set lastupdate, return</br>";
	return;
}
if (!isset($_GET['apivalid'])) {
	echo "did not set apivalid, return</br>";
	return;
}
if (!isset($_GET['note'])) {
	echo "did not set note, return</br>";
	return;
}

$account = $_GET['account'];
echo $account;
echo "</br>";
$lastupdate = $_GET['lastupdate'];
$apivalid = $_GET['apivalid'];
$note = $_GET['note'];

$servername = "localhost";
$username = "root";
$password = "";
 
// 创建连接
$conn = mysql_connect($servername, $username, $password);
if (!$conn) {
    die("Connection failed: " );
}
echo "Connection succeed</br>";

$db_selected = mysql_select_db('monitor', $conn );

if (!$db_selected) {
    die ('Can\'t use monitor : ' . mysql_error());
}
else {
	echo "Use monitor succeed</br>";
}

$query = sprintf("SELECT * FROM modifyprice 
    WHERE account='%s' ",
mysql_real_escape_string($account));

$result = mysql_query($query);
$row = mysql_fetch_assoc($result);

if (!$result || !$row) {
	echo "inserting</br>";
	
	$query = sprintf("INSERT INTO `monitor`.`modifyprice` (account, lastupdate, apivalid, note) VALUES ('%s', '%s', '%s', '%s') ",
	mysql_real_escape_string($account),
	mysql_real_escape_string($lastupdate),
	mysql_real_escape_string($apivalid),
	mysql_real_escape_string($note)
	);
    $result = mysql_query($query);
/*	mysql_query("INSERT INTO `monitor`.`modifyprice` (account, lastupdate, apivalid, note) VALUES ($account, $lastupdate, $apivalid, $note) ");  */

}
else {
	echo "item already exit, update it</br>" + $result;
	$query = sprintf("UPDATE modifyprice SET  lastupdate ='%s' , apivalid ='%s' , note ='%s'
		WHERE account='%s' ",
		mysql_real_escape_string($lastupdate),
		mysql_real_escape_string($apivalid),
		mysql_real_escape_string($note),
		mysql_real_escape_string($account));
	$result = mysql_query($query);
}

echo (mysql_error());

mysql_close($conn);

?>