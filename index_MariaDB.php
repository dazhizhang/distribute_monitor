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
$database = "";
 
// 创建连接
// $conn = mysqli_connect($servername, $username, $password);
$mysqli  = new mysqli($servername, $username, $password, $database);
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
echo "Connection succeed</br>";

// $db_selected = mysql_select_db('monitor', $conn );
$db_selected = $mysqli->select_db('monitor');

if (!$db_selected) {
    die ('Can\'t use monitor : ' . mysql_error());
}
else {
	echo "Use monitor succeed</br>";
}

$query = sprintf("SELECT * FROM modifyprice 
    WHERE account='%s' ",
mysqli_real_escape_string($mysqli,$account));

$result = $mysqli->query($query);
$row = $result->fetch_row();

if (!$result || !$row) {
	echo "inserting</br>";
	
	$query = sprintf("INSERT INTO `monitor`.`modifyprice` (account, lastupdate, apivalid, note) VALUES ('%s', '%s', '%s', '%s') ",
	mysqli_real_escape_string($mysqli,$account),
	mysqli_real_escape_string($mysqli,$lastupdate),
	mysqli_real_escape_string($mysqli,$apivalid),
	mysqli_real_escape_string($mysqli,$note)
	);
    $result = $mysqli->query($query);
/*	mysql_query("INSERT INTO `monitor`.`modifyprice` (account, lastupdate, apivalid, note) VALUES ($account, $lastupdate, $apivalid, $note) ");  */

}
else {
	echo "item already exit, update it</br>" + $result;
	$query = sprintf("UPDATE modifyprice SET  lastupdate ='%s' , apivalid ='%s' , note ='%s'
		WHERE account='%s' ",
		mysqli_real_escape_string($mysqli,$lastupdate),
		mysqli_real_escape_string($mysqli,$apivalid),
		mysqli_real_escape_string($mysqli,$note),
		mysqli_real_escape_string($mysqli,$account));
	$result = $mysqli->query($query);
}

echo ($mysqli->error);

$mysqli->close();

?>