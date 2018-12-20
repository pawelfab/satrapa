{include file="header.tpl"}
{include file="mcontainter.tpl"}

	</div>	
		<div id="container">
		<div class="list">
		<form method="POST" action="user.php?user=edit">
		
		    <table>
				{section name=user loop=$user}
				<tr>
					<td width="100" class="naglowek">Login</td>
					<td><input name="login" value="{$user[user].LOGIN}"></td>
				</tr>
				<tr>
					<td class="naglowek">Password</td>
					<td><input type="password" name="password" value="***"></td>
				</tr>
				<tr>
					<td class="naglowek">Imię</td>
					<td><input name="name" value="{$user[user].IMIE}"></td>
				</tr>
				<tr>
					<td class="naglowek">Nazwisko</td>
					<td><input name="surname" value="{$user[user].NAZWISKO}"></td>
				</tr>
				<tr>
					<td class="naglowek">adres</td>
					<td><input name="adres" value="{$user[user].ADRES}"></td>
				</tr>
				<tr>
					<td class="naglowek">pesel</td>
					<td><input name="pesel" value="{$user[user].PESEL}"></td>
				</tr>
				<tr>
					<td class="naglowek">telefon</td>
					<td><input name="telefon" value="{$user[user].TELEFON}"></td>
				</tr>
				<tr>
					<input type="hidden" name="edit" value="edit">
					<input type="hidden" name="userId" value="{$user[user].ID_U}">
					<td>&nbsp;</td>
					<td><button class="edytuj1" type="submit" value="Zatwierdz">Zatwierdź</button></td>
				</tr>
				{/section}
			</table>
			
		</form>
		</div>
		
		</div>
{include file="footer.tpl"}
