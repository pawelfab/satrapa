{include file="header.tpl"}
{include file="mcontainter.tpl"}

	</div>
	
	
	<div id="container">
		{if $smarty.get.raport <> 'ok'}
		<h3>Zlecenia które zostaną zaraportowane!</h3>
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
					<td width="140" class="naglowek">Data Zgłoszenia</td>
					{elseif $smarty.get.closed=='1'}
					<td width="140" class="naglowek">Data Zakończenia</td>
					{/if}
					
					
					
					
				</tr>
			<form method="POST" action="repairs.php?repair=rep_generate">
			
			{foreach item=v key=k from=$doRaportu}
				<tr {if $v.Compl_D <> "0000-00-00 00:00:00"} class="zakonczone" {elseif $v.gwar==true and $v.do_raportu==1} class="doraportu" {/if}>
					<td><b>{$v.id_repair}</b></td>
					<input type="hidden" name=raport[] value={$v.id_repair} />
					<td>{$v.manuf}</td>
					<td>{$v.model}</td>
					<td>{$v.nr_ser}</td>
					<td>{$v.nazwa}</td>
					<td>{$v.adrr}</td>
					{if $smarty.get.closed==null}
					<td>{$v.Reqes_D}</td>
					{elseif $smarty.get.closed=='1'}
					<td>{$v.Compl_D}</td>
					{/if}
					
					
				</tr>
			{/foreach}
		
		
		
			</table>
			
			{if $raport==ok}<h3 class="red">Wygenerowano raport</h3> {elseif $raport==err}<h3 class="red">Błąd zapisu</h3> {/if}
			{if $plik==true}<a href="raport.csv">raport do pobrania</a>  {/if}
			
				<input type="hidden" name="generate" value="generate">
				<td><button class="edytuj1" type="submit" value="Generuj">Generuj</button></td>
			</from>
			
		</div>
	
	</div>
	
	
	
{include file="footer.tpl"}