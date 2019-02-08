<?php
@include ('funkcje.php');
@include ('aukcja_config.php');
@session_start();
$_SESSION['currency']=$curr;
$_SESSION['czas']=$czas_na_odp;

$step_number=post_no();
if ($step_number>=0)	{
	for ($i=$step_number; $i>=0; --$i)	{
		if ($i==$step_number)	{
			echo "<table bgcolor='white'><tr id='pierwszy'><td>dostawca</td><td>pozycja</td><td>oferta</td><td>email it</td><td>z domiarem</td></tr>";
		}
		else	{
			echo "<table><tr id='pierwszy'><td>dostawca</td><td>pozycja</td><td>oferta</td><td>email it</td><td>z domiarem</td></tr>";
		}
		
		step_display($i);	
		echo "</table>";
	}
}
else	{
	echo "<div>Aukcja się jeszcze nie rozpoczęła</div>";
}


?>