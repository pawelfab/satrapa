{include file="header.tpl"}
{include file="mcontainter.tpl"}

	</div>	
	
		<div id="container">
		<div class="list">
		{section name=serwis loop=$serwis}
			<form method="POST" action="serwis.php?serwis=edit&id={$serwis[serwis].id_serwis}">
				
				<table class="add">
					
					<tr>
						<td class="naglowek">Nazwa</td>
						<td><input name="nazwa" value="{$serwis[serwis].nazwa_serwis}"></td>
					</tr>
					
					<tr>
						<td class="naglowek">Miasto</td>
						<td><input name="miasto" value="{$serwis[serwis].miasto_serwis}"></td>
					</tr>
					
					<tr>
						<input type="hidden" name="edit" value="edit">
						<input type="hidden" name="id" value="{$serwis[serwis].id_serwis}">
						<td>&nbsp;</td>
						<td><button class="edytuj1" type="submit" value="Zatwierdz">Zatwierdź</button></td>
					</tr>
					{/section}
				</table>
				
			</form>
			
			<div class="pagenr">	
			{if isset($addOK)}
				<span class="green">{$addOK}</span>
			{/if}
			{if isset($addNO)}
				<span class="red">{$addNO}</span>
			{/if}
			</div>
			
		</div>
		
		</div>
{include file="footer.tpl"}
