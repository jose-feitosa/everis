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
<form name="form" action="" method="post">
	<table>
		<tr>
			<td>
				<textarea readonly="true" style="background-color:#f1f1f1;" rows="4" cols="50">Este sistema serve para uma gestão simples de chamados, atendendo o documento "Everis - Teste Técnico - PHP.docx".
				</textarea>
			</td>
		</tr>
	</table>
</form>