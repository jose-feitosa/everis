<h2>Definições de Acesso ao Usuário</h2>     
<br>
<br>
<form action="" method="post">
	<table>
		<tr>
			<td><label for="username">Nome do Usuário: </label></td>
			<td><input type="text" name="username" id="username" style="background-color:#f1f1f1;" readonly="true" value="<?php echo $user['username']; ?>"></td>
		</tr>
		<tr>
			<td><label>Perfil do Usuário: </label></td>
			<td>  
				<select name="rolesid" id="rolesid">
					<option value="">Selecione...</option>
					<?php foreach ($roles as $role): ?>
					<option value="<?php echo $role['id'];?>"><?php echo $role['name'];?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<td></td>		
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Salvar"></td>
		</tr> 
    <input type="hidden" name="userid" value="<?php echo $user['userid'] ?>"> 
	<input type="hidden" name="rolename" />
</form>

<?php
	if (isset($_POST['username'])){
		if ($_POST['rolesid'] != ""){		
			foreach ($roles as $rol):
				if ($rol['id'] == $_POST['rolesid']){
					$_POST['rolename'] = $rol['name'];
				}
			endforeach;		
		
			$AcessoController = new App\controllers\AcessoController;
			$AcessoController->DefiniuAcesso();
		}
	}	
?>