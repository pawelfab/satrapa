<table class="editR" id="czesci" style="display:none">	
			
				<tr>
					<td class="naglowek">Części</td>
					<td class="naglowek" style="width:50">lokalizacja</td>
					<td class="naglowek">Napr.</td>
					<td class="naglowek" style="width:40">Fv nr.</td>
				</tr>
				
			{if ($RepairParts<>null)}	
			
			{foreach item=v key=k from=$RepairParts}
			
				<tr id="input{$k+1}" class="clonedInput">
					
					<td>
						<select style="width: 220px; height: 18px;" name="part{literal}[]{/literal}" id="part{literal}[]{/literal}">
							<option value="{$v.id_part}">{$v.part_name}: {$v.part_number}</option> 
								{foreach from=$parts item=foo}
								{assign var="part_name" value=$foo.part_name}
								{assign var="part_number" value=$foo.part_number}
								{assign var="id_part" value=$foo.id_part}
								{html_options values="$id_part" output="$part_name $part_number"}
								{/foreach}
						</select>
					</td>
					<td><input name="lokal{literal}[]{/literal}" id="lokal{literal}[]{/literal}" value="{$v.lokalizacja}"></td>
					<td>
						<select style="width: 40; height: 20;" name="napr{literal}[]{/literal}" id="napr{literal}[]{/literal}">
							<option value="{$v.part_conn_napr}">{$v.part_conn_napr}</option>
							<option value="A">A</option>
							<option value="Z">Z</option>
					</td>
					<td><input size="3" name="faktura{literal}[]{/literal}" id="faktura{literal}[]{/literal}" value="{$v.part_conn_fv}"></td>
				</tr>
					
			{/foreach}
			
			{else}
			
			
				<tr id="input1" class="clonedInput">
					
					<td>
						<select style="width: 240px; height: 18px;" name="part{literal}[]{/literal}" id="part{literal}[]{/literal}">
							<option value="{$v.id_part}">{$v.part_name} {$v.part_number}</option> 
								{foreach from=$parts item=foo}
								{assign var="part_name" value=$foo.part_name}
								{assign var="part_number" value=$foo.part_number}
								{assign var="id_part" value=$foo.id_part}
								{html_options values="$id_part" output="$part_name $part_number"}
								{/foreach}
						</select>
					</td>
					<td><input name="lokal{literal}[]{/literal}" id="lokal{literal}[]{/literal}"></td>
					<td>
						<select style="width: 40px; height: 18px;" name="napr{literal}[]{/literal}" id="napr{literal}[]{/literal}">
							<option value="A">A</option>
							<option value="Z">Z</option>
						</select>
					</td>
					<td><input size="3" name="faktura{literal}[]{/literal}" id="faktura{literal}[]{/literal}"></td>
				</tr>
				
			
			{/if}
			

				<tr>
					<td>
					<img src="view/img/back.png" alt="powrót" id="schowajCzesci">&nbsp;&nbsp;
					<img src="view/img/add.png" alt="dodaj część" id="btnAdd">&nbsp;&nbsp;
					<img src="view/img/remove.png" id="btnDel" alt="usun">
					</td>	
				</tr>
</table>
{*
<form enctype="multipart/form-data" action="__URL__" method="POST" style="display:none;">
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- Name of input element determines name in $_FILES array -->
    Send this file: <input name="userfile" type="file" />
    <input type="submit" value="Send File" />
</form>
*}
