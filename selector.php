<html>
	<head>
		<title>Selecionador de imagens</title>
		<script>
			var lista = [];
			var sels = [];
			function processar(){
				var urls = document.getElementById('urls').value;
				urls=urls.match(/[^\r\n]+/g);
				lista= [];
				for(var i in urls){
					if(!inLista(urls[i]))
						lista.push(urls[i]);
				}
				refreshTable();
			}
			function inLista(str){
				for(var i in lista){
					if(lista[i]==str)
						return true;
				}
				return false;
			}
			function refreshTable(){
				var outDiv = document.getElementById('imgs');
				outDiv.style.height = ''+outDiv.clientHeight+'px';
				outDiv.style.width = ''+outDiv.clientWidth+'px';
				while(outDiv.childNodes.length>0)
					outDiv.removeChild(outDiv.childNodes[0]);
				var tbl = document.createElement('table');
				//tbl.setAttribute('style','border:1px solid grey');
				var tr = null;
				var c = 0;
				for(var i in lista){
					if((c % 5)==0){
						tr = document.createElement('tr');
						tbl.appendChild(tr);
					}
					var td = document.createElement('td');
					var img = document.createElement('img');
					img.setAttribute('src',lista[i]);
					img.addEventListener('click',clicked);
					img.setAttribute('width', '' + ((outDiv.clientWidth-80)/5) + 'px');
					td.appendChild(img);
					tr.appendChild(td);
					c++;
				}
				outDiv.appendChild(tbl);
				var str = "";
				counter=1
				for(var i in lista){
					str += "[b][size=4]Foto "+counter+"[/b]\n\n[center][img width=800]"+lista[i]+"[/img][/center]\n\n\n";
					counter++;
				}
				document.getElementById('outz').value = str;
				alert('' + lista.length + " Imagens");
			}
			function clicked(e){
				var selected = -1;
				var c = 0;
				for(var i in sels){
					if(sels[i]==e.target.src){
						selected = c;
					}
					c++;
				}
				if(selected==-1){
					sels.push(e.target.src);
					e.target.style.border = '4px solid blue';
				}else{
					sels.splice(selected,1);
					e.target.style.border = '';
				}
			}
			function seleciona(){
				lista = sels;
				sels = [];
				refreshTable();
			}
			function remover(){
				while(sels.length>0){
					var itm = sels.splice(0,1);
					for(var i in lista){
						if(lista[i]==itm[0]){
							lista.splice(i,1);
							break;
						}
					}
				}
				refreshTable();
			}

		</script>






	</head>
	<body  bgcolor="#2f4f4f" style='margin:0px;border:0px'>

<script type="text/javascript">
function SelectAll(id)
{
    document.getElementById(id).focus();
    document.getElementById(id).select();
}
</script>



		<table style='width:100%;height:100%'>
			<tr>
				<td>
					<!--  <textarea id='urls' style='display:none'><?=shell_exec("./lsImages {$_GET['topic']}");?></textarea><br/>  -->
					<textarea id='urls' ><?=shell_exec("./lsImages {$_GET['topic']}");?></textarea><br/>  
					<input type='button' value='Carregar' onclick='processar()'/>
				</td>
				<td>
					<input type='button' value='Selecionar' onclick='seleciona()'/>
					<input type='button' value='Remover' onclick='remover()'/>
				</td>
				<td>
					<textarea id='outz' onClick="SelectAll('outz');"  ></textarea>
				</td>
			</tr>
			<tr>
				<td colspan='3'  style='height:100%;border:1px solid black'>
					<div id='imgs' style="overflow:scroll;height:100%;width:100%">
					</div>
				</td>
			</tr>
		</table>
	</body>
</html>
