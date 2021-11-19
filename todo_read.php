<?php
session_start();
include("functions.php");
check_session_id();
$user_id = $_SESSION['id'];

$pdo = connect_to_db();

$sql = 'SELECT * FROM todo_table
          LEFT OUTER JOIN (SELECT todo_id, COUNT(id) AS cnt
          FROM like_table GROUP BY todo_id) AS likes
          ON todo_table.id = likes.todo_id';
// $sql = "SELECT * FROM todo_table";

$stmt = $pdo->prepare($sql);
exec_query($stmt);

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";
foreach ($result as $record) {
  $output .= "<tr>";
  $output .= "<td>{$record["deadline"]}</td>";
  $output .= "<td>{$record["todo"]}</td>";
  $output .= "<td><button><a href='like_create.php?user_id={$user_id}&todo_id={$record["id"]}'>like</a></button>{$record["cnt"]}</td>";;
  $output .= "<td><a href='todo_edit.php?id={$record["id"]}'>edit</a></td>";
  $output .= "<td><a href='todo_delete.php?id={$record["id"]}'>delete</a></td>";
  $output .= "</tr>";
}
unset($value);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB連携型todoリスト（一覧画面）</title>
</head>

<body>
  <fieldset>
    <legend>DB連携型todoリスト（一覧画面）</legend>
    <a href="todo_input.php">入力画面</a>
    <a href="todo_logout.php">logout</a>
    <table>
      <thead>
        <tr>
          <th>deadline</th>
          <th>todo</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>