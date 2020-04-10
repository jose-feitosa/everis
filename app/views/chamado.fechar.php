<h2>Atendimento ao Chamado - Fechamento</h2>

<?php 
	$descricao = "";
	$obs = "";
	$idchm = 0;
	$obsfunc = "";
	foreach ($chamados as $chm):
		$descricao = $chm['descricao'];
		$obs = $chm['comentariocliente'];
		$idchm = $chm['chamadoid'];
		$obsfunc = $chm['comentariofuncionario'];
	endforeach;	
?>
 
<form name="form" action="" method="post">
	<table>
		<tr>
			<td><label for="descricao">Solicitação: </label></td>
			<td><input type="text" name="descricao" readonly="true" style="background-color:#f1f1f1; width:371px;"; value="<?php echo $descricao; ?>" id="descricao"></td>
		</tr>
		<tr>
			<td><label for="comentario">Observação Solicitante: </label></td>
			<td>
				<textarea id="comentario" name="comentario" readonly="true" style="background-color:#f1f1f1;" rows="4" cols="50"><?php echo $obs; ?></textarea>
			</td>
		</tr>
		<tr>
			<td><label>Análise Inicial</label></td>
			<td><textarea id="analise" name="analise" readonly="true" style="background-color:#f1f1f1;" rows="4" cols="50"><?php echo $obsfunc; ?></textarea></td>		
		</tr>
		<tr>
			<td><label>Solução Implementada</label></td>
			<td><textarea id="solucao" name="solucao" rows="4" cols="50"></textarea></td>		
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Salvar" /></td>
		</tr>
	</table>	
	<input type="hidden" name="chamadoid" value="<?php echo $idchm; ?>">
</form>

<?php
	if (isset($_POST['solucao'])){
		if ($_POST['solucao'] != ''){		
			$ChamadoController = new App\controllers\ChamadoController;
			$ChamadoController->fechar();
		}
	}	
?>