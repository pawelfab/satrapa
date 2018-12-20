{include file="header.tpl"}
{include file="mcontainter.tpl"}
	
	<div id="container">
		<div class="list">
		
			<div class="red">
				{validate id="numer_seryjny" message="Pole numer seryjny nie może być puste!"}
				{validate id="fullname" message="Pole Imię nie może być puste!"}
			</div>
			
		<form method="POST" action="repairs.php?repair=edit">
		{section name=repair loop=$repair}
		    <table class="edit">
				
				<tr>
					<td width="100" class="naglowek">Id naprawy</td>
					<td><input name="id_napr" size="10" disabled="disabled" style="color:black" value="{$repair[repair].id_repair}"></td>
				</tr>
				<tr>
					<td class="naglowek">Gwarancja</td>
					<td><input type="checkbox" name="gwar" value="1" {if ($repair[repair].gwar==true)} checked="checked"{/if} /></td>
				</tr>
				{if ($repair[repair].gwar==false)}
				<tr>
					<td class="naglowek">Status kosztorysu</td>
					<td>
						<select name="status_koszt">
						<option value="{$repair[repair].id_stat_koszt}">{$repair[repair].stat_koszt}</option> 
							{foreach from=$status_koszt item=foo}
								{html_options values=$foo.id_stat_koszt output=$foo.stat_koszt}
							{/foreach}
						</select>
					</td>	
				</tr>
				{/if}
				<tr>
					<td class="naglowek">Model</td>
					<td>
						<select name="chosenm">
						<option value="{$repair[repair].model}">{$repair[repair].model}</option> 
							{foreach from=$model item=foo}
								{html_options values=$foo.model output=$foo.model}
							{/foreach}
						</select>
					</td>	
				</tr>
				<tr>
					<td class="naglowek">Numer seryjny</td>
					<td><input name="numer_seryjny" value="{$repair[repair].nr_ser}"></td>
				</tr>
				<tr>
					<td class="naglowek">CRT_Ser/ilość stron</td>
					<td><input name="CRT_Ser" value="{$repair[repair].CRT_Ser}"></td>
				</tr>
				<tr>
					<td class="naglowek">Imię</td>
					<td><input type="text" name="klient" value="{$repair[repair].nazwa}"></td>
				</tr>
				<tr>
					<td class="naglowek">Nazwisko</td>
					<td><input type="text" name="klient2" value="{$repair[repair].nazwa2}"></td>
				</tr>
				<tr>
					<td class="naglowek">Miasto</td>
					<td><input name="miasto" value="{$repair[repair].adrr}"></td>
				</tr>
				<tr>
					<td class="naglowek">Kod pocztowy</td>
					<td><input name="kod_poczt" style="width: 45px; padding: 2px" value="{$repair[repair].kod_poczt}"></td>
				</tr>
				<tr>
					<td class="naglowek">Ulica</td>
					<td><input name="ulica" value="{$repair[repair].adrr2}"></td>
				</tr>
				<tr>
					<td class="naglowek">Numer domu/mieszkania</td>
					<td><input name="nrdomu" value="{$repair[repair].adrr3}"></td>
				</tr>
				<tr>
					<td class="naglowek">Numer telefonu</td>
					<td><input name="nr_tel" value="{$repair[repair].Cons_Tel1}"></td>
				</tr>
				<tr>
					<td class="naglowek">Data Zakupu urządzenia</td>
					<td><input name="Purch_D" value="{$repair[repair].Purch_D}" id="date" style="width:120"></td>
					
				</tr>
				<tr>
					<td class="naglowek">Opis uszkodzenia</td>
					<td><textarea rows="4" cols="30" name="Def_Desc">{$repair[repair].Def_Desc}</textarea></td>					
				</tr>
				<tr>
					<td class="naglowek">Opis Naprawy</td>
					<td><textarea rows="4" cols="30" name="Rep_Desc">{$repair[repair].Rep_Desc}</textarea></td>
				</tr>
				
			</table>
				
				
			<table class="editR" id="statusy">
				<tr>
					<td class="naglowek">Data rozpoczęcia naprawy</td>
					<td><input name="Start_D" value="{$repair[repair].Start_D}" id="datepicker" style="width:120"/></td>
					
				</tr>
				<tr>
					<td class="naglowek">Data zgłoszenia naprawy (wprowadzenia do systemu)</td>
					<td><input name="Reqes_D" value="{$repair[repair].Reqes_D}" id="datepicker1" style="width:120"/></td>
					
				</tr>
				<tr>
					<td class="naglowek">Data zakończenia naprawy</td>
					<td><input name="Compl_D" value="{$repair[repair].Compl_D}" id="datepicker2" style="width:120"/></td>
				</tr>
				<tr>
					<td class="naglowek">Status Serwisu</td>
					<td>
						<select name="ServStatus">
						<option value="{$repair[repair].id_stat_serw}">{$repair[repair].ServStatus}</option> 
							{foreach from=$servStatus item=foo}
								{html_options values=$foo.id_stat_serw output=$foo.ServStatus}
							{/foreach}
						</select>
					</td>	
				</tr>
				<tr>
					<td class="naglowek">Typ Naprawy</td>
					<td>
						<select name="TypNapr">
						<option value="{$repair[repair].id_typ_napr}">{$repair[repair].tNapr}</option> 
							{foreach from=$TypNapr item=foo}
								{html_options values=$foo.id_typ_napr output=$foo.tNapr}
							{/foreach}
						</select>
					</td>	
				</tr>
				<tr>
					<td class="naglowek">Rodzaj Naprawy</td>
					<td>
						<select name="RodzNapr">
						<option value="{$repair[repair].id_rodz_napr}">{$repair[repair].rodzNaprawy}</option> 
							{foreach from=$RodzNapr item=foo}
								{html_options values=$foo.id_rodz_napr output=$foo.rodzNaprawy}
							{/foreach}
						</select>
					</td>	
				</tr>
				<tr>
					<td class="naglowek">Serwisant</td>
					<td>
						<select name="Serwisant">
						<option value="{$repair[repair].id_serwisant}">{$repair[repair].serwisant_name}</option> 
							{foreach from=$serwisanci item=foo}
								{html_options values=$foo.id_serwisant output=$foo.serwisant_name}
							{/foreach}
						</select>
					</td>	
				</tr>
				<tr>
					<td class="naglowek">Transport</td>
					<td><input type="checkbox" name="id_Transp" value="1" {if ($repair[repair].id_Transp==true)} checked="checked"{/if} /></td>
				</tr>
				<tr>
					<td class="naglowek">Wartość części</td>
					<td><input name="Par_Cost" value="{$repair[repair].Par_Cost}" style="width:60"></td>
					
				</tr>
				<tr>
					<td class="naglowek">Wartość robocizny</td>
					<td><input name="Lab_Cost" value="{$repair[repair].Lab_Cost}" style="width:60"></td>
					
				</tr>
				<tr>
					<td class="naglowek">Wartość transportu</td>
					<td><input name="Tra_Cost" value="{$repair[repair].Tra_Cost}" style="width:60"></td>
					
				</tr>
				<tr>
					<td class="naglowek">Inne koszty</td>
					<td><input name="Oth_Cost" value="{$repair[repair].Oth_Cost}" style="width:60"></td>
					
				</tr>
				<tr>
					<td class="naglowek">Do raportu</td>
					<td><input type="checkbox" name="do_raportu" value="1" {if ($repair[repair].do_raportu==true)} checked="checked"{/if} /></td>
				</tr>
				<tr>
					<td class="naglowek">Zaraportowane</td>
					<td><input type="checkbox" name="zaraportowane" value="1" {if ($repair[repair].zaraportowane==true)} checked="checked"{/if} /></td>
				</tr>
				
				<tr>
					<td class="naglowek">Serwisy</td>
					<td>
					<select name="serwisy">
						<option value="{$repair[repair].id_serwis}">{$repair[repair].nazwa_serwis}</option> 
							{foreach from=$serwisy item=foo}
								{assign var="nazwa_serwis" value=$foo.nazwa_serwis}
								{assign var="miasto_serwis" value=$foo.miasto_serwis}
								{html_options values=$foo.id_serwis output="$nazwa_serwis $miasto_serwis"}
							{/foreach}
					</select>
					</td>
				</tr>
				
				<tr>
					<td class="naglowek">Części</td>	
					<td><img src="view/img/add.png" alt="dodaj części" id="pokazCzesci"></td>			
				</tr>
				
				<tr>
					<td class="naglowek">Raport-płatne</td>	
					<td><a href="javascript:view('repairs.php?repair=print&repairId={$repair[repair].id_repair}&image=copynet.jpg',screen.width,screen.height)"><img src="view/img/print.png" alt="Drukuj" id="pokazCzesci"></a></td>			
				</tr>
				<tr>
					<td class="naglowek">Raport-gwarancje</td>	
					<td><a href="javascript:view('repairs.php?repair=print&repairId={$repair[repair].id_repair}&image=samsung.jpg',screen.width,screen.height)"><img src="view/img/print.png" alt="Drukuj" id="pokazCzesci"></a></td>			
				</tr>
				<tr>
					<input type="hidden" name="edit" value="edit">
					<input type="hidden" name="repairId" value="{$repair[repair].id_repair}">
					<input type="hidden" name="id_naprawy" value="{$repair[repair].id_repair}">
					<input type="hidden" name="KlientId" value="{$repair[repair].id_customer}">
					<input type="hidden" name="DeviceId" value="{$repair[repair].id_dev}">
					<td>&nbsp;</td>
					<td><button class="edytuj1" type="submit" value="Zatwierdz">Zatwierdź</button></td>
					
				</tr>
				
			</table>
			
		{include file="repair_parts.tpl"}
		
		{/section}
				
			
		</form>
		</div>
		
	</div>
{include file="footer.tpl"}
