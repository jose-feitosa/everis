<?php if (count($mainmenu) > 0): ?>
<nav>
	<ul class="menu">
		<?php foreach ($mainmenu as $main): ?>
		<li><a href="#"><?php echo $main['descricaomenu']; ?></a>
			<ul>
				<?php foreach ($submenu as $sub): ?>
				<?php if ($main['codigomenu'] == $sub['codigomenupai']){?>				
				
				<?php if ($sub['isclient'] != 1 && $sub['nomeobjeto'] != 'chamado'){?>
				<li><a href="router_view.php?objeto=<?= $sub['nomeobjeto'];?>&view=index&isclient=<?php echo $sub['isclient']; ?>"><?php echo $sub['descricaomenu']; ?></a></li>
				<?php }?>
				
				<?php if ($sub['isclient'] != 1 && $sub['nomeobjeto'] == 'chamado'){?>
				<li><a href="router_view.php?objeto=<?= $sub['nomeobjeto'];?>&view=funcionario&isclient=<?php echo $sub['isclient']; ?>"><?php echo $sub['descricaomenu']; ?></a></li>
				<?php }?>				
				
				<?php if ($sub['isclient'] == 1 && $sub['nomeobjeto'] == 'chamado'){?>
				<li><a href="router_view.php?objeto=<?= $sub['nomeobjeto'];?>&view=cliente&isclient=<?php echo $sub['isclient']; ?>"><?php echo $sub['descricaomenu']; ?></a></li>
				<?php }?>				
				
				<?php } ?>				
				<?php endforeach; ?>				
			</ul>
		</li>
		<?php endforeach; ?>
		<li><a href="router_view.php?objeto=sis&view=sair">Sair</a></li>
	</ul>
</nav>

<?php endif; ?>

<br>
<br>

<h1>Definições de Acesso ao Usuário</h1>
 
<?php if (count($userroles) > 0): ?> 
 
<table width="50%" border="1" cellpadding="2" cellspacing="0">
 
<thead> 
  <tr> 
    <th>Usuário</th>
	<th>Perfil</th> 
	<th>Ações</th> 
  </tr> 
</thead>
  
   <tbody>
   <?php foreach ($userroles as $user): ?> 
   <tr> 
	  <td><?php echo $user['username']; ?></td>
	  <td><?php echo $user['rolesname']; ?></td>
 	  <td>
		<a href="router_view.php?objeto=acesso&view=defineacesso&id=<?php echo $user['userid']; ?>"><button>Definir Acesso</button></a>
      </td> 
   </tr>
 
   <?php endforeach; ?>
   </tbody>
 
</table>
 
 
<?php else: ?>
 
 
 
Nenhum usuário cadastrado
 
 
<?php endif; ?>