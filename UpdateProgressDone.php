<?php
require_once "function.php";

$Content = $_POST['dataContent'];
$UserId = $_POST['UserId'];

echo $Content;
echo $UserId;

UpdateContentDataTranlation($Content,$UserId);
UpdateStatusResolved($UserId);

?>