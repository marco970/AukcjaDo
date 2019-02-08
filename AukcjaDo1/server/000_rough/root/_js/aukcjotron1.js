$(document).ready(function() {	
	$.get('process.php', {decide: 'form'}, DisplayForm);	//wyświetlenie formularza do wpisywania ofert
	function DisplayForm(form_php)	{
		$('#formularz').html(form_php);
	}
}); // koniec funkcji ready
//------------------------------------------------------
$(document).ready(function() {	//click przycisku formularza, php generuje albo form z błędem albo wyświetlone dane, które w następnym kroku są zapisywane
	$('.link_mail').hide();
	$( "body" ).delegate( '#button', "click", function()	{	//click jw
		$('.form_displ').hide();
		//$(this).css('border: 5px solid navy');
		var data_oferty = $('#oferty').serialize();
			$.get('val_oferty.php', data_oferty, ResultOferty);
			function ResultOferty(php_oferty)	{
				$('#formularz').html(php_oferty);
			}	
	});
	$( "body" ).delegate( '#button3', "click", function()	{
		location.reload();
	});
	$( "body" ).delegate( '#link_mail', "click", function()	{
		$(this).css("color", "red");
	});
	$( "body" ).delegate( '.pole', "click", function()	{
		$(this).css("background", "#CCFFFF");
	});
}); // koniec funkcji ready
$(document).ready(function() {	
	$.get('step_display.php', DisplayStep);	//wyświetlanie ofert w kolejnych krokach
	function DisplayStep(php_step_display)	{
		$('#wyniki').before(php_step_display);
	}
	
}); // koniec funkcji ready

