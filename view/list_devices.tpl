{include file="header.tpl"}
{include file="mcontainter.tpl"}	
	
	<div id="container">
	
	
{if $page_numbers.total > 1}
(page {$page_numbers.current} / {$page_numbers.total})<br />
{$pager_links}
{/if}
		
		<div class="list">
			<table>
				<tr>
					<td width="40" class="naglowek">Id</td>
					<td width="100" class="naglowek">producent</td>
					<td width="140" class="naglowek">model</td>
					<td width="140" class="naglowek">numer seryjny</td>
					<td width="140" class="naglowek">data sprzedaży</td>
				{*	{if $listaWyp eq 1} <td width="70" class="naglowek">wybór</td> 
					{elseif $rezerwuj eq 1} <td width="70" class="naglowek">Rezerwuj</td> 
					{else} <td width="70" class="naglowek">Edycja</td>
					<td width="50" class="naglowek">Usuń</td>
					{/if}
				*}
				</tr>
		{foreach item=v key=k from=$devices}
				<tr>
					<td><b>{$v.id_dev}</b></td>
					<td>{$v.manuf}</td>
					<td>{$v.model}</td>
					<td>{$v.nr_ser}</td>
					<td>{$v.Purch_D}</td>
				{*	{if $listaWyp eq 1}
					<td><button class="edytuj1" onclick="javascript:location.href='film.php?film=wypozycz&filmId={$v.ID_F}'">Wybierz</button></td>
					{elseif $rezerwuj eq 1}
					<td><button class="edytuj1" onclick="javascript:location.href='film.php?film=rezerwuj&filmId={$v.ID_F}'">Rezerwuj</button></td>
					{else}
					<td><button class="edytuj1" onclick="javascript:location.href='film.php?film=edit&filmId={$v.ID_F}'">Wybierz</button></td>
					<td><button class="edytuj1" onclick="if(confirm('Napewno chcesz usunąć tą pozycję?')) javascript:location.href='film.php?film=delete&filmId={$v.ID_F}'"><img src="view/img/usun.png" /></button></td>
					{/if}
				*}
				</tr>
		{/foreach}
		
		
		
			</table>
			
		</div>
	</div>	
	
{include file="footer.tpl"}
