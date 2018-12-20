{include file="header.tpl"}
	
	<div id="logo">
			<h3>Satrapa</h3>
			<img src="view/img/satrapa.png" />
		</div>
	<div id="container1">
		{if $error==1}<p class="red">Nieudane logowanie</p>{/if}
			<form name="formularz" method="post" action="login.php">
				<ul>
				Login:
				<input name="login" type="text"><br>
				Hasło:
				<input name="password" type="password"><br>
				
				<button class="edytuj1" type="submit" value="zaloguj">Zaloguj</button>
				<ul>
			</form>
	 </div>
	
{include file="footer.tpl"}
