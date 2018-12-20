{include file="header.tpl"}
{include file="mcontainter.tpl"}	
	
	
	<div id="container">	
		<div class="list">
			<table class="add">
				<tr>
					<td width="100" class="naglowek">Nazwa Części</td>
					<td width="140" class="naglowek">Cena sprzedaży</td>
					<td width="140" class="naglowek">Numer katalogowy</td>	
					<td width="140" class="naglowek">Numer handlowy</td>	
				</tr>
		{foreach item=v key=k from=$parts}
				<tr>
					<td><b>{$v.part_name}</b></td>
					<td>{$v.cena_sprzed}</td>
					<td>{$v.indeks_kat}</td>
					<td>{$v.indeks_handl}</td>
				</tr>
		{/foreach}
			</table>	
		</div>
		
		
		{if $page_numbers.total > 1}
		(page {$page_numbers.current} / {$page_numbers.total})<br />
		{$pager_links}
		{/if}
		
		
	</div>	
	

	
{include file="footer.tpl"}
