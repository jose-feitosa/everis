<?php
	require 'vendor/autoload.php';

	if (isset($users)){
		echo count($users)."<br>";
	}
?>

<h2>Login de Acesso</h2>

<form action="" method="post">
	<table>
		<tr>
			<td><label>Nome do Usuário: </label></td>
			<td><input type="text" name="login" id="login"></td>
		</tr>
		<tr>
			<td><label>Password: </label></td>
			<td><input type="password" name="senha" id="senha"></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Acessar" /></td>
		</tr>
	</table>
</form>

<?php
	if (isset($_POST['login'])){
		$UserController = new App\controllers\UserController;
		$UserController->login();
	}	
?>
