<h2>Cadastro de Usuários - Inclusão</h2>
          
 
<form name="form" action="" method="post">
	<table>
		<tr>
			<td><label for="username">Nome do Usuário: </label></td>
			<td><input type="text" name="username" id="username"></td>
		</tr>
		<tr>
			<td><label for="password">Password: </label></td>
			<td><input type="password" name="password" id="password"></td>
		</tr>
		<tr>
			<td><label>Confirmação</label></td>
			<td><input type="password" name="confirmacao" id="confirmacao"></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Salvar" /></td>
		</tr>
	</table>
</form>

<script>
	<?php if (($_POST['username'] != '') && ($_POST['password'] != $_POST['confirmacao'])){?>
	alert('A senha não confere!');
	<?php }?>
</script>

<?php
	if (isset($_POST['username'])){
		if (($_POST['username'] != '') && ($_POST['password'] == $_POST['confirmacao'])){		
			$UserController = new App\controllers\UserController;
			$UserController->store();
		}
	}	
?>