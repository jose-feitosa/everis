<h2>Cadastro de Usuários - Edição</h2>          
 
<form action="" method="post">
	<table>
		<tr>
			<td><label for="username">Nome do Usuário: </label></td>
			<td><input type="text" name="username" id="username" value="<?php echo $user['username']; ?>"></td>
		</tr>
		<tr>
			<td><label for="password">Password: </label></td>
			<td><input type="password" name="password" id="password" value="<?php echo $user['password']; ?>"></td>
		</tr>
		<tr>
			<td><label>Confirmação</label></td>
			<td><input type="password" name="confirmacao" id="confirmacao" /></td>
		</tr>
		<tr>
			<td></td>		
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Salvar"></td>
		</tr> 
	</table>
    <input type="hidden" name="userid" value="<?php echo $user['userid'] ?>">    
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
			$UserController->update();
		}
	}	
?>