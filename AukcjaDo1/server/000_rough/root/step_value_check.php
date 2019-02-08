<?php
@include ('funkcje.php');
session_start();
if (!isset($_SESSION['step_value']))	{
	$_SESSION['step_value']=1;
}
echo "<p>minimalne postąpienie ".$_SESSION['step_value']."</p>";

?>