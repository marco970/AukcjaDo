<?php
###################################################
##wszystkie funkcje PHP
###################################################

###################################################
##łączenie z bazą
function lacz_bd()
{
	$connection = mysql_pconnect('localhost', 'root', 'usbw' );
	$wynik = mysql_select_db('aukcjotron', $connection)
	// w przypadku niepowodzenia wyświetlamy komunikat 
	or die('Nie mogę połączyć się z bazą danych<br />Błąd: '.mysql_error());  
	if (!$wynik){
		//echo "nie udało się połączyć z bd</br>";
	}
	else {
		// echo "udało się połączyć z bd</br>";   	
	return $wynik;
	}
}
#################################################
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
return $lista;

}
################################################
##zapisz oferty rundy do bazy
function zapisz_post($dost_name, $oferta, $post_value)	{	//tu zaczynamy
$post_id=post_no()+1;

}
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
$post_id=0;
}

return max(array($post_id));
}
##################################################
##wyświetla formularz do podania danych
function display_form_input($err, $lista_dost, $liczba_ofert, $val)	{
$k=$liczba_ofert;
echo '<form id="oferty" action="index.php" method="post" class="form_displ">';
for ($i=1; $i<=$k; ++$i)	{
echo "
<div>
	<label for=".$lista_dost[$i]." class='label'>".$lista_dost[$i]."&nbsp</label><input type='text' name=".$lista_dost[$i]." size='12' maxlength='12' id=".$lista_dost[$i]." value=".$val[$i]." ><label>&nbsp".$err[$i]."&nbsp</label>
</div>";
}
echo "<input type='button' value='jeszcze dalej' name='button' id='button'></form>";
}
##################################################
##zapis rundy ofert do bazy
function step_save($step_number, $step_value, $lista_dost, $val, $pos, $k)	{
	lacz_bd();
	for ($i=1; $i<=$k; ++$i)	{
		$wynik = mysql_query("insert into oferty values ('', '$step_number', '$lista_dost[$i]', '$val[$i]', '$pos[$i]', '$step_value')");	
	}
}
##################################################
##wyśietla rundę z bazy
function step_display()	{
	$step_number=post_no();
	$k=ilosc_dostawcow();
	$wynik= mysql_query("select * from `oferty` where `step_id`='$step_number'" ); 
	$i=1;
	while($wektor = mysql_fetch_array($wynik, MYSQL_BOTH)) {
		$dostawca[$i]=$wektor[2];
		$oferta[$i]=$wektor[3];
		$pozycja[$i]=$wektor[4];
		$min_postąpienie[$i]=$wektor[5];
		++$i;
	}
	echo "<div>numer postąpienia ".$step_number."</div><div>min. krok postąpienia ".$min_postąpienie[1]."</div>";
	for ($i=1; $i<=$k, ++$i)	{
		echo "<div>pozycja->".$pozycja[$i]."&nbsp&nbsp".$dostawca[$i]."&nbsp=".$oferta[$i]."</div>";
	}
	echo "<div>---------------------------------------------------</div>";
}
?>