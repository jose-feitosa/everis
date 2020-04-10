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

<h1>Meus Chamados</h1>
 
<a href="router_view.php?objeto=chamado&view=create&clienteid=<?php echo $user; ?>"><button>Abertura de Novos Chamados</button></a> 
 
<table width="50%" border="1" cellpadding="2" cellspacing="0">
 
<thead> 
  <tr> 
    <th>Nº Chamado</th>
	<th>Descrição</th>
	<th>Comentário Solicitando</th>
	<th>Atendente</th>
	<th>Comentário Atendente</th>
	<th>Solução para o Chamado</th>
	<th>Situação do Chamado</th>
	<th>Lido ?</th> 
  </tr> 
</thead>
 
   <tbody>
   <?php foreach ($chamados as $call): ?> 
   <tr> 
	  <td><?php echo $call['chamadoid']; ?></td>
	  <td><?php echo $call['descricao']; ?></td>
	  <td><?php echo $call['comentariocliente']; ?></td>
	  <td><?php echo $call['atendente']; ?></td>
	  <td><?php echo $call['comentariofuncionario']; ?></td>	  
	  <td><?php echo $call['solucaofuncionario']; ?></td>
	  <td><?php echo $call['situacao_chamado']; ?></td>
	  
 	  <td>
		<?php if ($call['status'] == 'S'){?>
		<a href="router_view.php?objeto=chamado&view=lido&idchamado=<?php echo $call['chamadoid']; ?>"><button>Clicar como Lido</button></a>
		<?php }?>
	  </td>
 
   </tr>
 
   <?php endforeach; ?>
   </tbody>
 
</table>