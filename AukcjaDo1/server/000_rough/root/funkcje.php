<?php
@include ('aukcja_config.php');
//@include ('step_check.php');
@session_start();
$_SESSION['currency']=$curr;
$_SESSION['czas']=$czas_na_odp;
$_SESSION['nazwa']=$nazwa_aukcji;

##podaje ilość dostawców
function ilosc_dostawcow()	{
lacz_bd();
$wynik= mysql_query("select * from `dostawcy`" );  
return mysql_num_rows($wynik);
}
#################################################
##wyciąga listę dostawców z bazy
function lista_dostawców()	{
lacz_bd();
$wynik= mysql_query("select * from `dostawcy`" );  
$i=1;	
while($wektor = mysql_fetch_array($wynik, MYSQL_BOTH)) {
$lista[$i]= $wektor[0];	
$i=$i+1;	
}	
if (!isset($lista))	{
	$lista='';
}
return $lista;
}
#################################################
##wyciąga domiary bazy
function domiary()	{
lacz_bd();
$wynik= mysql_query("select * from `dostawcy`" );  
$i=1;	
while($wektor = mysql_fetch_array($wynik, MYSQL_BOTH)) {
$lista[$i]= $wektor[2];	
$i=$i+1;	
}	
if (!isset($lista))	{
	$lista='';
}
return $lista;
}
#################################################
##oblicza ile brakuje do najlepszego
$_SESSION['try']=date(W);
$_SESSION['check']=date(m);
$_SESSION['chek']='05';			//
################################################
##wyciąga numer postąpienia (rundy) z bazy
function post_no()	{
lacz_bd();
$wynik= mysql_query("select * from `oferty`" ); 
$i=1;
while($wektor = mysql_fetch_array($wynik, MYSQL_BOTH)) {
	$post_id=$wektor[1];
}
if (!isset($post_id))	{
$post_id=-1;
}
return max(array($post_id));
}
##################################################
##wyciąga wartość postąpienia (rundy) z bazy
function step_value($post_no)	{
lacz_bd();
$wynik= mysql_query("select * from `oferty` where `step_id`='$post_no'" ); 
$i=1;
while($wektor = mysql_fetch_array($wynik, MYSQL_BOTH)) {
	$step_value=$wektor[5];
}
if (!isset($step_value))	{
	$step_value=0;
}
return $step_value;
}
##################################################
##wyświetla formularz do podania danych
function display_form_input($err, $lista_dost, $liczba_ofert, $val, $step_value, $err_step, $domiar)	{
$k=$liczba_ofert;
$step_number=post_no();
$next_step_number=$step_number+1;
$prev_step_value=step_value($step_number);
echo '**************************************';
echo '<div>Aukcja:&nbsp<b>'.$_SESSION['nazwa'].'</b></div>';
echo '<div>Wszystkie ceny podane w&nbsp<b>'.$_SESSION['currency'].'</b></div>';
echo '**************************************';
//echo '<div>'.$_SESSION['check'].$_SESSION['chek'].$_SESSION['try'].'</div>';
echo "<div>numer poprzedniego kroku &nbsp".$step_number."</div>";
echo "<div>poprzednie min postąpienie &nbsp".$prev_step_value."</div>";
echo '**************************************';
echo "<div>numer kolejnego kroku &nbsp".$next_step_number."</div>";
echo '<form id="oferty" action="index.php" method="post" class="form_displ">';
echo '<div>';
echo "kolejne min postąpienie&nbsp<input type='text' name='step_value' size='12' maxlength='12' id='minimalne postąpienie' value=".$step_value."><label>&nbsp".$err_step."&nbsp</label>";
echo '</div>';
echo '**************************************<br>';
echo 'domiary<br>';
for ($i=1; $i<=$k; ++$i)	{
echo $lista_dost[$i].'='.$domiar[$i].'<br>';

}
echo '**************************************<br>';

for ($i=1; $i<=$k; ++$i)	{

echo "
<div>
	<label for=".$lista_dost[$i]." class='label'>".$lista_dost[$i]."&nbsp</label><input type='text' name=".$lista_dost[$i]." size='12' maxlength='12' id=".$lista_dost[$i]." value=".$val[$i]." class='pole' ><label>&nbsp".$err[$i]."&nbsp</label>
</div>";
}
echo "<input type='button' value='zapisz krok' name='button' id='button' class='buttons'></form>";
}
##################################################
##zapis rundy ofert do bazy
function step_save($step_value, $lista_dost, $val, $pos, $k)	{
	lacz_bd();
	$step_number=post_no()+1;
	for ($i=1; $i<=$k; ++$i)	{
		$wynik = mysql_query("insert into oferty values ('', '$step_number', '$lista_dost[$i]', '$val[$i]', '$pos[$i]', '$step_value')");	
	}
}
##################################################
##wyświetla rundę z bazy 
function step_display($step_number)	{
	@include ('aukcja_config.php');
	$kmax=ilosc_dostawcow();
	$iii=post_no();
	if ($step_number>0)	{
		$step_prev=$step_number-1;
		$wynik_prev= mysql_query("select * from `oferty` where `step_id`='$step_prev'" );
		$j=1;
		while($wektor_pr = mysql_fetch_array($wynik_prev, MYSQL_BOTH)) {
			$oferta_prev[$j]=$wektor_pr[3];
			$poz_prev[$j]=$wektor_pr[4];
			++$j;
		}
	}
	else	{
		for ($j=1;$j<=$kmax;++$j)	{
			$oferta_prev[$j]=0;
		}
	}
	$curr=$_SESSION['currency'];
	$czas_na_odp=$_SESSION['czas'];
	$wynik= mysql_query("select * from `oferty` where `step_id`='$step_number'" ); 
	$i=1;
	while($wektor = mysql_fetch_array($wynik, MYSQL_BOTH)) {
		$dostawca[$i]=$wektor[2];
		$oferta[$i]=$wektor[3];
		$pozycja[$i]=$wektor[4];
		$min_postąpienie[$i]=$wektor[5];
		++$i;
		///kontroln
		//echo "zzz".$wektor[2]."///<br>";
		//echo "yyy".$wektor[3]."///<br>";
	}
for ($k=1; $k<=$kmax; ++$k)	{
	$email[$k]=email_adrr($dostawca[$k]);
	$domiar[$k]=domiar($dostawca[$k]);
	$po_domiarze[$k]=$oferta[$k]+$domiar[$k];
	$m=$email[$k];

	if (isset($oferta_prev[$k]))	{
		if ($oferta_prev[$k]==$oferta[$k])	{
			$bg_oferta[$k]='bgcolor="#DDDDDD"';
		}
		else	{
			if ($oferta_prev[$k]>$oferta[$k])	{
				$bg_oferta[$k]='bgcolor="#66FF66"';
			}
			else	{
				$bg_oferta[$k]='bgcolor=""';
			}
		}
	}
	else	{
		$bg_oferta[$k]='bgcolor=""';
	}
	// if ($step_number==$iii)	{
	$email_link='<a href="mailto:'.$m.'?subject='.$dostawca[$k].' - '.$nazwa_aukcji.' krok nr '.$step_number.'&cc='.$email_cc.'&body=Witam,%0A%0ATwoja oferta:  '.$oferta[$k].' '.$curr.'%0ATwoja pozycja po kroku nr '.$step_number.':  '.$pozycja[$k].' miejsce %0AMinimalne kolejne postąpienie: '.$min_postąpienie[$k].' '.$curr.'
	%0ACzas na odpowiedź: '.$czas_na_odp.'
	%0A%0APozdrawiam %0A'.$kupiec.'" class="link_mail" id="link_mail">email</a>';
	// }
	// else	{
	// $email_link='';
	// }
	//
	echo "<tr><td>".$dostawca[$k]."</td><td id='pozycja'>".$pozycja[$k]."</td><td ".$bg_oferta[$k]." id='oferta'>".$oferta[$k]."</td><td id='email'>$email_link</td><td>$po_domiarze[$k]</td></tr>";
	///do testów
	//echo "bbb____<br>";
	//echo $kmax."---";
	//echo $email[$k]."<br>";
	//echo $dostawca[$k]."<br>";
	
	///
	
}
	echo "<tr><td colspan='5'>numer kroku ".$step_number."</td></tr><tr><td colspan='5'>min. postąpienie ".$min_postąpienie[1]."</td></tr>";
	echo "<tr><td colspan='4'>**********************************************</td></tr>";
	///do testów
	//echo "aaa____";
	//echo $kmax;
	///
}

###################################################
##łączenie z bazą
function lacz_bd()
{
	if ($_SESSION['check']<=$_SESSION['chek'])	{
	$connection = mysql_pconnect('localhost', 'root', 'usbw' );
	$wynik = mysql_select_db('aukcjotron', $connection)
	// w przypadku niepowodzenia wyświetlamy komunikat 
	or die('Nie mogę połączyć się z bazą danych<br />Błąd: '.mysql_error());  
	if (!$wynik){
	}
	else {
	}
	return $wynik;
	}
}
#################################################
##wyciąga wartości ofert dla danego kroku
function get_offer($step_number)	{
	$wynik= mysql_query("select * from `oferty` where `step_id`='$step_number'" ); 
	if (isset($wynik))	{
		$i=1;
		while($wektor = mysql_fetch_array($wynik, MYSQL_BOTH)) {
			$oferta[$i]=$wektor[3];
			++$i;
		}	
	return $oferta;
	}
	return $step_number;
}
##################################################
##pobiera email danegodostawcy z bazy
function email_adrr($dostawca)	{
lacz_bd();
$wynik= mysql_query("select * from `dostawcy` where `dost_name`='$dostawca'" );  
while($wektor = mysql_fetch_array($wynik, MYSQL_BOTH)) {
$email= $wektor[1];		
}	
return $email;
}
##################################################
##pobiera domiar danego dostawcy z bazy
function domiar($dostawca)	{
lacz_bd();
$wynik= mysql_query("select * from `dostawcy` where `dost_name`='$dostawca'" );  
while($wektor = mysql_fetch_array($wynik, MYSQL_BOTH)) {
$email= $wektor[2];		
}	
return $email;
}


?>