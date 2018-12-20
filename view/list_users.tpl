{include file="header.tpl"}
{include file="mcontainter.tpl"}	


	<div id="container">

		
		<div class="list">
			<table>
				<tr>
					
					
					<td width="100" class="naglowek">Imię</td>
					<td width="140" class="naglowek">Nazwisko</td>
					<td width="140" class="naglowek">login</td>
					
					
				</tr>
		{foreach item=v key=k from=$users}
				<tr>
					
					
					<td>{$v.IMIE}</td>
					<td>{$v.NAZWISKO}</td>
					<td>{$v.LOGIN}</td>
				{*	<td><button class="edytuj1" onclick="javascript:location.href='user.php?user=dane&userId={$v.ID_U}'">Wybierz</button></td>
					<td><button class="edytuj1" onclick="if(confirm('Napewno chcesz usunąć tą pozycję?')) javascript:location.href='user.php?user=delete&userId={$v.ID_U}'"><img src="view/img/usun.png" /></button></td>
				*}
				</tr>
		{/foreach}
			</table>
		</div>
		
	</div>
	
	{if $page_numbers.total > 1}
	(page {$page_numbers.current} / {$page_numbers.total})<br />
	{$pager_links}
	{/if}
	
{include file="footer.tpl"}
