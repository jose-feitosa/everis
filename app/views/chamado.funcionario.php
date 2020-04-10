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

<h1>Chamados Abertos / Em Atendimento</h1>

<table width="50%" border="1" cellpadding="2" cellspacing="0">
 
<thead> 
  <tr> 
    <th>Nº Chamado</th>
	<th>Solicitação</th>
	<th>Observação Solicitante</th>
	<th>Solicitante</th>
	<th>Situação Chamado</th>
	<th>Análise Inicial</th>
	<th>Ações</th>
  </tr> 
</thead>
 
   <tbody>
   <?php foreach ($chamados as $call): ?> 
   <tr> 
	  <td><?php echo $call['chamadoid']; ?></td>
	  <td><?php echo $call['descricao']; ?></td>
	  <td><?php echo $call['comentariocliente']; ?></td>
	  <td><?php echo $call['solicitante']; ?></td>
	  <td><?php echo $call['situacao_chamado']; ?></td>
	  <td><?php echo $call['comentariofuncionario']; ?></td>
	  
 	  <td>
		<?php if ($call['status'] != 'A'){?>
		<a href="router_view.php?objeto=chamado&view=inicioatendimento&idchamado=<?php echo $call['chamadoid']; ?>"><button>Iniciar Atendimento</button></a>
		<?php }?>
		
		<?php if ($call['status'] == 'A'){?>
		<a href="router_view.php?objeto=chamado&view=concluiratendimento&idchamado=<?php echo $call['chamadoid']; ?>"><button>Concluir Atendimento</button></a>
		<?php }?>
	  </td>
 
   </tr>
 
   <?php endforeach; ?>
   </tbody>
 
</table>