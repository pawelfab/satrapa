{include file="header.tpl"}
{include file="mcontainter.tpl"}


	</div>	
		<div id="container">
		<h3>Dodaj użytkownika</h3>
		<div class="list">
		<form method="POST" action="user.php?user=new">
		    <table class="add">
					<tr>
					<td width="100" class="naglowek">Login</td>
					<td><input name="login" value="" ></td>
				</tr>
				<tr>
					<td class="naglowek">Password</td>
					<td><input name="password" type="password" value=""></td>
				</tr>
				<tr>
					<td class="naglowek">Imię</td>
					<td><input name="name" value=""></td>
				</tr>
				<tr>
					<td class="naglowek">Nazwisko</td>
					<td><input name="surname" value=""></td>
				</tr>
				<tr>
					<input type="hidden" name="new" value="new">
					<td>&nbsp;</td>
					<td><button class="edytuj1" type="submit" value="Dodaj">Dodaj</button></td>
				</tr>
			</table>
		</form>
		</div>
		
		</div>
{include file="footer.tpl"}
