
	<div id="container1">
			
		<div id="logo">
			<h3>Satrapa</h3>
			<img src="view/img/satrapa.png" />
		</div>

		{if ($smarty.session.user.0.AUTH) eq "a"}
		{include file="menu.tpl"}
		
		{else}
		{include file="menu1.tpl"}
		{/if}
		
		<div class="user">
			Jesteś zalogowany jako:</br>
			<b>{$smarty.session.user.0.IMIE} {$smarty.session.user.0.NAZWISKO}</b>
		</div>
		<div class="user">
		<span style="color:red;margin:5px">Naprawa ponad 10 dni</span><br>
		<span style="color:yellow;margin:5px">Naprawa ponad 5 dni</span>
		</div>
		<div class="user">
		<p><b>Zmiany w programie:</b></p>
		<p>Dodano części z WFMAG</p>
		<p></p>
		<p></p>
		<p></p>
		<p></p>
		</div>
	</div>