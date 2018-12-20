{include file="header.tpl"}
{include file="mcontainter.tpl"}


	</div>	
		<div id="container">
		<h3>Dodaj Naprawę</h3>
		<div class="list">
		<form id="add_repair" method="POST" action="repairs.php?repair=new">
			
		    <table class="add">
				<tr>
					<td class="naglowek">Id naprawy</td>
					<td><input name="id" disabled style="color:black" value="{$lastId}"></td>
					
				</tr>
				
				<tr>
					<td class="naglowek">Model</td>
					<td class="komorka">
						<select class="required" name="model_id">
						<option value="">--wybierz model--</option> 
							{foreach from=$model item=foo}
								{html_options values=$foo.id_model output=$foo.model}
							{/foreach}
						</select>
					</td>
				</tr>
				
				<tr>
					<td class="naglowek">Numer seryjny</td>
					<td class="komorka"><input id="nr_ser" name="nr_ser" ></td>
				</tr>
				
				<tr>
				<td class="komorka">&nbsp;</td><td class="komorka">&nbsp;</td>
				</tr>
				
				
				
				
					<td><a id="link1" href="#" class="naglowek">Wprowadź klienta / Wybierz klienta z bazy</a></td>
					
				
				
			</table>	
			 <table class="add" id="Box1" style="display:none;">	
					<div >
					
						<tr>
							<td class="naglowek">Nazwisko</td>
							<td class="naglowek"><input class="txt" name="nazwa2" value="{$repair[repair].nazwa2}"></td>
						</tr>
						<tr>
							<td class="naglowek">Imię</td>
							<td class="naglowek"><input class="txt" name="nazwa" value="{$repair[repair].nazwa}"></td>
						</tr>
						<tr>
							<td class="naglowek">Miasto</td>
							<td class="naglowek"><input class="txt" name="adres" value="{$repair[repair].adrr}"></td>
						</tr>
						<tr>
							<td class="naglowek">Ulica</td>
							<td class="naglowek"><input class="txt" name="adrr2" value="{$repair[repair].adrr2}"></td>
						</tr>
						<tr>
							<td class="naglowek">Nr domu/mieszkania</td>
							<td class="naglowek"><input class="txt" name="adrr3" value="{$repair[repair].adrr3}"></td>
						</tr>
						<tr>
							<td class="naglowek">Kod pocztowy</td>
							<td class="naglowek"><input name="kod_poczt" value="{$repair[repair].kod_poczt}"></td>
						</tr>
						<tr>
							<td class="naglowek">Telefon</td>
							<td class="naglowek"><input class="txt" name="Cons_Tel1" value="{$repair[repair].Cons_Tel1}"></td>
						</tr>
			
					</div>
			</table>	
			 <table class="add" id="Box2">
					
					<div >
					<tr>
						<td class="naglowek">Wybierz klienta</td>
							<td>
								<select class="required" style="width: 150px; height: 18px;float:right" name="customer_id">
								<option value="">--wybierz klilenta--</option> 
									{foreach from=$customers item=foo}
										{assign var="customeradrr" value=$foo.adrr}
										{assign var="customernazwa" value=$foo.nazwa}
										{assign var="customernazwa2" value=$foo.nazwa2}
										{assign var="customerid" value=$foo.id_customer}
										{html_options values="$customerid" output="$customernazwa    $customernazwa2   $customeradrr"}									
									{/foreach}
								</select>
								
							</td>
						</td>
					</tr>
					</div>
			</table>
				
				<tr>
					<input type="hidden" name="new" value="new">
					<input name="id_naprawy" type="hidden" value="{$lastId}">
					<input type="hidden" name="repairId" value="{$repair[repair].id_repair}">
					<input type="hidden" name="KlientId" value="{$repair[repair].id_customer}">
					<input type="hidden" name="DeviceId" value="{$repair[repair].id_dev}">
					<td>&nbsp;</td>
					<td><button type="submit" value="Dodaj">Dodaj</button></td>
				</tr>
				
				
								
			
		
		</form>
		
		</div>
		</div>
	
{include file="footer.tpl"}
