<?php
session_start();
include 'db.php';
if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit; }
$user_id = (int)$_SESSION['user_id'];
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($id){
  $conn->query("DELETE FROM cart WHERE id=$id AND user_id=$user_id");
}
header("Location: cart.php");
exit;
