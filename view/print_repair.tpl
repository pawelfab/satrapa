{include file="head_print.tpl"}
{section name=repair loop=$repair}	
	<div id="container">
		<div id="logo1">
			<ul>
			<li>Copy.net.pl</li>
			<li>Office Automation</li>
			<li>Ul. 29 Listopada 18a lok.2</li>
			<li>00-465 Warszawa</li>
			<li>tel. 22 8809042</li>
			</ul>
		</div>
		
		<div id="logo2">
			<img src="view/img/logo.jpg" alt="logo" height="97" width="378"> 
		</div>
		
		
		<div id="miasto">
			Warszawa................
		</div>
		
		<div id="content">
			<ul>
				<li>Nazwa typ urządzenia:   {$repair[repair].model} </li>
				<li>Miejsce użytkowania/Komórka organizacyjna: {$repair[repair].nazwa} {$repair[repair].adrr2} {$repair[repair].adrr3} {$repair[repair].kod_poczt} {$repair[repair].adrr}</li>
				<li>Opis uszkodzenia: {$repair[repair].Def_Desc}</li>
				<li>Raport z wykonanych czynności (wymienione części):..................................</li>
				<li>Numer seryjny urządzenia   {$repair[repair].nr_ser}</li>
				<li>Licznik kopii {$repair[repair].CRT_Ser}</li>
			</ul>
		</div>
		
		<div id="sign">
			<ul>
				<li>Podpis użytkownika</li>
				<li>Podpis wykonawcy</li>
			</ul>
		</div>
			
		
		
	</div>
{/section}
{include file="footer.tpl"}
