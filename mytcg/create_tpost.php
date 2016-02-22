<?php require_once('settings.php');
include('header.php');

$connect = mysql_connect("$db_server", "$db_user", "$db_password");
mysql_select_db("$db_database", $connect);

$create_tpost = "ALTER TABLE `members` ADD `tpost` VARCHAR( 3 ) NOT NULL";

if (mysql_query($create_games, $connect)) {
   echo "<code>tpost</code> was successfully added to <strong>$table_members</strong>.<br />\n";
}
else {
   die("Error: ". mysql_error());
}

echo "For security purposes, please remove this file from your server!\n";
include('footer.php'); ?>
