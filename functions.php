<?php

function connect_to_db()
{
  $dbn = 'mysql:dbname=gsacf_09_04;charset=utf8;port=3306;host=localhost';
  $user = 'root';
  $pwd = '';

  try {
    return new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    echo json_encode(["db エラー：" => "{$e->getMessage()}"]);
    exit();
  }
}

function exec_query($stmt)
{
  try {
    $stmt->execute();
  } catch (PDOException $e) {
    exit("SQL エラー：" . $e->getMessage());
  }
}

function check_session_id()
{
  if (
    !isset($_SESSION["session_id"]) ||
    $_SESSION["session_id"] != session_id()
  ) {
    header("Location:todo_login.php");
  } else {
    session_regenerate_id(true);
    $_SESSION["session_id"] = session_id();
  }
}
