{include file="header.tpl"}
{include file="mcontainter.tpl"}


	</div>	
		<div id="container">
		<h3>Dodaj Urządzenie</h3>
		<div class="list">
		<form method="POST" action="devices.php?device=new">
		    <table class="add">
					<tr>
					<td width="100" class="naglowek">Producent</td>
					<td><input name="manuf" value=""></td>
				</tr>
				<tr>
					<td class="naglowek">Model</td>
					<td><input name="model" value=""></td>
				</tr>
				
				
				<tr>
					<input type="hidden" name="new" value="new">
					<td>&nbsp;</td>
					<td><button class="edytuj1" type="submit" value="Dodaj">Dodaj</button></td>
				</tr>
			</table>
		</form>
		</div>
		
			<div class="pagenr">	
			{if isset($addOK)}
				<span class="green">{$addOK}</span>
			{/if}
			{if isset($addNO)}
				<span class="red">{$addNO}</span>
			{/if}
			</div>
		
	</div>
{include file="footer.tpl"}
