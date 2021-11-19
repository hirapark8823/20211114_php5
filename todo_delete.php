<?php
session_start();
include("functions.php");
check_session_id();

$id = $_GET["id"];

$pdo = connect_to_db();

$sql = "DELETE FROM todo_table WHERE id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

exec_query($stmt);
header("Location:todo_read.php");
exit();
