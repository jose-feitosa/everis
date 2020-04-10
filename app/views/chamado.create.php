<h2>Abertura de Chamado</h2>
 
<form name="form" action="" method="post">
	<table>
		<tr>
			<td><label for="descricao">Descrição: </label></td>
			<td><input type="text" name="descricao" id="descricao"></td>
		</tr>
		<tr>
			<td><label for="comentario">Observação: </label></td>
			<td>
				<textarea id="comentario" name="comentario" rows="4" cols="50"></textarea>
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Salvar" /></td>
		</tr>
	</table>
	<input type="hidden" name="clienteid" value="<?php echo $clienteid; ?>">
</form>

<?php
	if (isset($_POST['descricao'])){
		if ($_POST['descricao'] != ''){		
			$ChamadoController = new App\controllers\ChamadoController;
			$ChamadoController->store();
		}
	}	
?>