<?php
session_start();
$_SESSION['step_value']=$_POST['step_value'];
echo "<p>minimalne postąpienie ".$_SESSION['step_value']."</p>";



?>