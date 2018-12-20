{include file="header.tpl"}
{include file="mcontainter.tpl"}


	</div>	
		<div id="container">
		<h3>Dodaj Część</h3>
		<div class="list">
		<form id="add_part" method="POST" action="devices.php?part=new">
		    <table class="add">
					<tr>
					<td width="100" class="naglowek">Nazwa części</td>
					<td><input class="txt" name="part_name" value=""></td>
				</tr>
				<tr>
					<td class="naglowek">Cena</td>
					<td><input id="cena_sprzed" name="cena_sprzed" value="" ></td>
				</tr>
				<tr>
					<td class="naglowek">Numer katalogowy</td>
					<td><input class="txt" name="indeks_kat" value="" ></td>
				</tr>
				<tr>
					<td class="naglowek">Numer handlowy</td>
					<td><input class="txt" name="indeks_handl" value="" ></td>
				</tr>
				<tr>
					<input type="hidden" name="new" value="new">
					<td>&nbsp;</td>
					<td><button class="edytuj1" type="submit" value="Dodaj">Dodaj</button></td>
				</tr>
			</table>
		</form>
		{if $AddOk==true} <br><span class="red"><h4>Dodano nową część</h4></span>{/if}
		</div>
		
		
		
	</div>
{include file="footer.tpl"}
