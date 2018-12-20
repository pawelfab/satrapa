{include file="header.tpl"}
{include file="mcontainter.tpl"}	
	
	
	
	<div id="container">
	
		{if $smarty.get.repair=='search'} <tr><ul class="red">Wyniki wyszukiwania</ul></tr> {/if}

		<form method="POST" action="repairs.php?repair=search">
			<table cellspacing="0" celpadding="0" class="search">
				<tr>
					<td width="70">id naprawy</td>
					<td width="40"><input width="20" type="text" name="id_repair"/></td>
					<td width="80">producent</td>
					<td width="70"><input type="text" name="manuf"/></td>
					<td width="70">model</td>
					<td width="70"><input type="text" name="model"/></td>
					<td width="70">numer ser</td>
					<td width="70"><input type="text" name="nr_ser"/></td>
					<td width="70">Klient</td>
					<td width="90"><input type="text" name="klient"/></td>
					<td><input type="submit" value="szukaj" style="width:70px;"></td>
					
				</tr>
			</table>
		</form>
	

	
		<div class="list">
			<table class="lista">
				<tr>
					<td width="40" class="naglowek"><a href="repairs.php?repair=list&sort=id_repair">Id naprawy</a></td>
					<td width="100" class="naglowek">producent</td>
					<td width="140" class="naglowek"><a href="repairs.php?repair=list&sort=model">model</a></td>
					<td width="140" class="naglowek">numer seryjny</td>
					<td width="140" class="naglowek"><a href="repairs.php?repair=list&sort=nazwa">Klient</a></td>
					<td width="140" class="naglowek">Adres</td>
					{if $smarty.get.closed==null}
					<td width="140" class="naglowek">Data Rozpoczęcia</td>
					{elseif $smarty.get.closed=='1'}
					<td width="140" class="naglowek">Data Zakończenia</td>
					{/if}
					<td width="70" class="naglowek">Status</td>
					
					
					
					
				</tr>
		{foreach item=v key=k from=$repairs}
				<tr {if $v.Compl_D <> null} class="zakonczone" {/if} {if $v.repairdays>10} style="color:red;" {elseif $v.repairdays>5} style="color:#AEB404;" {/if} onclick="javascript:location.href='repairs.php?repair=edit&repairId={$v.id_repair}'">
					<td><b>{$v.id_repair}</b></td>
					<td>{$v.manuf}</td>
					<td>{$v.model}</td>
					<td>{$v.nr_ser}</td>
					<td>{$v.nazwa2}</td>
					<td>{$v.adrr}</td>
					{if $smarty.get.closed==null}
					<td>{$v.Reqes_D}</td>
					{elseif $smarty.get.closed=='1'}
					<td>{$v.Compl_D}</td>
					{/if}
					<td>{$v.ServStatus}</td>
					
					
					
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
