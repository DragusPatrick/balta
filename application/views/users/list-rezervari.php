<div class="container">
	<div class="row">
		<div class="col s12">
			<div class="panel panel-primary">
				<div class="row">
						<p> Nume: <?php echo $user->nume; ?><br/>
							Email: <?php echo $user->mail; ?><br/>
							Telefon:<?php echo $user->telefon; ?>
						</p>
						
				</div>
				<div class="panel-heading">
					<div class="panel-title"><span class="fa fa-group"></span> Lista Useri</div>
				</div>
				<div class="panel-body pn">
					<table id="users-list" class="table striped table-hover" cellspacing="0" width="100%" data-ajax-dt="users/view/<?php echo $user->id ?>">
						<thead>
						<tr class="dark">
							<th class="all">Id</th>
							<th class="all">Pachet CR </th>
							<th class="all">Pachet Retinere</th>
							<th class="all">Loc</th>
							<th class="all">Cost Total</th>
							<th class="all">Hash</th>
							<th class="all">Data Emitere</th>
							<th class="all">Actiuni</th>
						</tr>
						
						</thead>
						<tbody>
						
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>