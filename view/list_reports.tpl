{include file="header.tpl"}
{include file="mcontainter.tpl"}	
	
	<div id="container">
		{if $smarty.get.raport <> 'ok'}
		<h3>Zlecenia gwarancyjne które zostaną dodane do listy raportu</h3>
		{/if}
		<div class="list">
			<table>
				<tr>
					<td width="40" class="naglowek">Id naprawy</td>
					<td width="100" class="naglowek">producent</td>
					<td width="140" class="naglowek">model</td>
					<td width="140" class="naglowek">numer seryjny</td>
					<td width="140" class="naglowek">Klient</td>
					<td width="140" class="naglowek">Adres</td>
					{if $smarty.get.closed==null}
					<td width="140" class="naglowek">Data Rozpoczęcia</td>
					{elseif $smarty.get.closed=='1'}
					<td width="140" class="naglowek">Data Zakończenia</td>
					{/if}
					<td width="140" class="naglowek">Do raportu</td>
					
					
					
					
				</tr>
			<form method="POST" action="repairs.php?repair=rep_generate">
			{foreach item=v key=k from=$doRaportu}
				<tr {if $v.Compl_D <> "0000-00-00 00:00:00"} class="zakonczone" {/if}>
					<td><b>{$v.id_repair}</b></td>
					<td>{$v.manuf}</td>
					<td>{$v.model}</td>
					<td>{$v.nr_ser}</td>
					<td>{$v.nazwa}</td>
					<td>{$v.adrr}</td>
					{if $smarty.get.closed==null}
					<td>{$v.Start_D}</td>
					{elseif $smarty.get.closed=='1'}
					<td>{$v.Compl_D}</td>
					{/if}
					<td><input type="checkbox" name=do_raportu[] value={$v.id_repair} /></td>
					
					
				</tr>
			{/foreach}
		
		
		
			</table>
			
			{if $raport==ok}<h3 class="red">Zapisano zlecenia do raportu</h3>{/if}
			{if $brak_wyboru==1}<h3 class="red">Nie wybrano zleceń</h3>{/if}
			
				<input type="hidden" name="update" value="update">
				<td><button class="edytuj1" type="submit" value="Generuj">Zapisz</button></td>
			</from>
			
		</div>
	
	</div>
	
	
	
{include file="footer.tpl"}