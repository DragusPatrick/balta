
<div id="modal-form" class="popup-basic admin-form theme-primary mfp-with-anim">
	<div class="panel">
		<div class="panel-heading">
			<span class="panel-title"><i class="fa fa-edit"></i>Modificare User</span>
		</div>
		<?php if(isset($user_val->id)) : ?>
			
			<form method="post" action="/users/save_changes/<?php echo $user_val->id; ?>" data-form-dt="users-list">
				<div class="panel-body ">
					<div class="alert alert-danger alert-micro hidden"></div>
					
					<div class="row">
						<div >
							<label for="name" class="field prepend-icon">
								<input type="text" name="name" id="name" class="gui-input" placeholder="Nume & prenume" value="<?php echo $user_val->nume; ?>">
								<label for="name" class="field-icon"><i class="fa fa-star"></i>
								</label>
							</label>
						</div>
						
						<div >
							<label for="email" class="field prepend-icon">
								<input type="text" name="email" id="email" class="gui-input" placeholder="E-mail" value="<?php echo $user_val->mail; ?>">
								<label for="email" class="field-icon"><i class="fa fa-envelope-o"></i>
								</label>
							</label>
						</div>
						
						<div>
							<label for="name" class="field prepend-icon">
								<input type="text" name="telefon" id="name" class="gui-input" placeholder="Telefon" value="<?php echo $user_val->telefon; ?>">
								<label for="name" class="field-icon"><i class="fa fa-star"></i>
								</label>
							</label>
						</div>
						
						
					</div>
				</div>
				
				
				<div class="panel-footer text-center">
					<a type="submit" class="btn btn-success btn-sm dark"><i class="fa fa-save mr5"></i>Vezi Istoric</a>
					<button type="submit" class="btn btn-success btn-sm dark"><i class="fa fa-save mr5"></i> Salveaza</button>
				</div>
			</form>
		<?php else : ?>
			<div class="panel-body p25 text-danger text-center">
				<div class="mb10 fs40">
					<i class="fa fa-exclamation-triangle mr5"></i>
				</div>
				HEllo
				A intervenit o eroare la citirea datelor, va rugam reincarcati pagina si incercati iar!
			</div>
		<?php endif; ?>
	
	
	</div>
	
	<button title="Close (Esc)" type="button" class="mfp-close">&times;</button>
</div>