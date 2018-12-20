{include file="header.tpl"}
{include file="mcontainter.tpl"}	
	
	<div id="container">
	
	

		
		<div class="list">
			<table>
				<tr>
					<td width="40" class="naglowek">Id</td>
					<td width="100" class="naglowek">Nazwa</td>
					<td width="140" class="naglowek">Miasto</td>
					<td width="30" class="naglowek">Edytuj</td>
					<td width="30" class="naglowek">Usuń</td>
				</tr>
		{foreach item=v key=k from=$serwis}
				<tr>
					<td><b>{$v.id_serwis}</b></td>
					<td>{$v.nazwa_serwis}</td>
					<td>{$v.miasto_serwis}</td>
					<td><button class="edytuj1" onclick="javascript:location.href='serwis.php?serwis=edit&id={$v.id_serwis}'"> <img src="view/img/edit.png" /></a></button></td>
					<td><button class="edytuj1" onclick="if(confirm('Napewno chcesz usunąć tą pozycję?')) javascript:location.href='serwis.php?serwis=delete&id={$v.id_serwis}'"><img src="view/img/delete.png" /></button></td>
					
				
				</tr>
		{/foreach}
		
		
		
			</table>
			
		</div>
	<div class="pagenr">	
		{if $page_numbers.total > 1}
		(page {$page_numbers.current} / {$page_numbers.total})<br />
		{$pager_links}
		{/if}
	</div>
		
	</div>	
	
{include file="footer.tpl"}
