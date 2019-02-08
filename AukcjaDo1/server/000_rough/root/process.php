<?php
@include ('funkcje.php');
@session_start();
$k = ilosc_dostawcow();
$step_number=post_no();
$domiar=domiary();
if (!isset($_SESSION['step_value']))	{
	$_SESSION['step_value']=step_value($step_number);
}
if ($_GET['decide']=='form')	{
	$lista_dost=lista_dostawców();
	if ($step_number>=0)	{
		$oferta=get_offer($step_number);
	}
	else	{
		for ($i=1; $i<=$k; ++$i)	{
		$oferta[$i]='';
		}
	}
		
	for ($i=1; $i<=$k; ++$i)	{
		$err[$i]='';
		$val[$i]=$oferta[$i];
		$err_step='';
	}
	display_form_input($err, $lista_dost, $k, $val, $_SESSION['step_value'], $err_step, $domiar);
}




?>