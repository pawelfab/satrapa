{include file="header.tpl"}
{include file="mcontainter.tpl"}


	</div>	
		<div id="container">
		<h3>Dodaj Serwis</h3>
		<div class="list">
		<form method="POST" action="serwis.php?serwis=new">
		    <table class="add">
					<tr>
					<td width="100" class="naglowek">Nazwa Serwisu</td>
					<td><input name="nazwa" value=""></td>
				</tr>
				<tr>
					<td class="naglowek">Miasto</td>
					<td><input name="miasto" value="" ></td>
				</tr>
				
				
				<tr>
					<input type="hidden" name="new" value="new">
					<td>&nbsp;</td>
					<td><button class="edytuj1" type="submit" value="Dodaj">Dodaj</button></td>
				</tr>
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
