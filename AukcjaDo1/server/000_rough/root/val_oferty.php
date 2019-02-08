<?php
@include ('funkcje.php');
$k = ilosc_dostawcow();
$lista_dost=lista_dostawców();
$domiar=domiary();
$step_number=post_no();
$prev_step_value=step_value($step_number);
$err_step='';
@session_start();
if (!isset($_SESSION['step_value']))	{
$_SESSION['step_value']=step_value($step_number);
}
else {
	if (isset($_GET['step_value']))	{
		if ($_GET['step_value']>=0 && is_numeric($_GET['step_value']))	{
			$_SESSION['step_value']=$_GET['step_value'];
			$err_step='';
		}
		else	{
			$err_step='nieprawidłowa wartość';
		}
	}
}
for ($i=1; $i<=$k; ++$i)	{
	$valo[$i]=$_GET[$lista_dost[$i]];
	$val[$i]=$valo[$i];
	$valx[$i]=$valo[$i]+$domiar[$i];
	//echo $valx[$i]."--".$val[$i]."<br>";
}
if ($step_number>=0)	{
$oferta=get_offer($step_number);
}
else	{
	for ($i=1; $i<=$k; ++$i)	{
		$oferta[$i]=$val[$i];
	}
}
for ($i=1; $i<=$k; ++$i)	{
	$diff=$oferta[$i]-$val[$i];
	$exp_offer=$oferta[$i]-$_SESSION['step_value'];
	
	if ($val[$i]!=''&&is_numeric($val[$i]))	{	//waliduje wartość z formularza
		if ($diff>=$prev_step_value||$diff==0)	{
			$err[$i]='';
		}
		else	{
			$err[$i]="oferta powinna być mniejsza od&nbsp".$exp_offer."&nbspalbo być równa&nbsp".$oferta[$i]."";
			$val[$i]=$oferta[$i];	//w przypadku gdy oferta obniża się mniej, niż powinna, w formularzu pojawi się kwota jak poprzednio
			$error=1;
		}
	}
	else	{
		$error=1;
		$err[$i]='błąd';
	}
}
if (isset($error))	{
	display_form_input($err, $lista_dost, $k, $val, $_SESSION['step_value'], $err_step, $domiar);
}
else	{

	for ($m=1; $m<=$k; ++$m)	{
		$pos[$m]=$k;
		for ($n=1; $n<=$k; ++$n)	{
			if ($valx[$m]<$valx[$n])	{
				$pos[$m]=$pos[$m]-1;
			}
		}
	}
	//wyświetlenie pozycji
	echo '<b>zapisano następujący krok aukcji:</b>';
	for ($i=1; $i<=$k; ++$i)	{
		echo "<div>pozycja->".$pos[$i]."&nbsp&nbsp".$lista_dost[$i]."&nbsp=".$val[$i]."</div>";
	}
	echo "<input type='button' value='utwórz maile do oferentów' name='button3' id='button3' class='buttons'></form>";
	//zapis do bazy
	$step_number=post_no()+1;
	step_save($_SESSION['step_value'], $lista_dost, $val, $pos, $k);
}

?>