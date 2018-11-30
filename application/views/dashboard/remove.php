
<div id="modal-form" class="popup-basic admin-form theme-primary mfp-with-anim">
	<div class="panel">
		<div class="panel-heading">
			<span class="panel-title"><i class="fa fa-edit"></i>Sterge Rezervare</span>
		</div>
		<?php if(isset($rezervare->id_rez)) : ?>
			
			<form method="post" action="/dashboard/remove_rezervare/<?php echo $rezervare->id_rez; ?>" data-form-dt="rezervari-list">
				
				<div class="panel-body ">
					<div class="alert alert-danger alert-micro hidden"></div>
						<p style="font-size: 20px;text-align: center;color: red;margin-bottom: 40px;"> Confirmare stergere rezervare </p>
						<div class="row center-align">
							<button type="submit" class="btn btn-success btn-sm dark"><i class="fa fa-save mr5"></i> Sterge</button>
						</div>
					</div>
				</div>


			</form>
		<?php else : ?>
			<div class="panel-body p25 text-danger text-center">
				<div class="mb10 fs40">
					<i class="fa fa-exclamation-triangle mr5"></i>
				</div>
				
				A intervenit o eroare la citirea datelor, va rugam reincarcati pagina si incercati iar!
			</div>
		<?php endif; ?>
	
	
	</div>
	
	<button title="Close (Esc)" type="button" class="mfp-close">&times;</button>
</div>