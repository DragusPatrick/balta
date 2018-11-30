<div class="container">
	<div class="row">
		<div class="col s12">
			<div class="panel panel-primary">
				<div class="panel-body pn">
					
					<form  id="settingsForm">
						<h2 style="text-align: center;font-size: 30px;color: #634141;text-transform: uppercase;"> Setari Site </h2>
						
						<div class="row">
							<div class="input-field col s6">
					                <input id="costcr" type="number" name="costcr" value="<?php echo $costcr ?>">
					                <label for="costcr" class="active">Cost Catch and Release</label>
	              			</div>

	              			<div class="input-field col s6">
					                <input id="costrc" type="number" name="costrc" value="<?php echo $costrc ?>">
					                <label for="costrc" class="active">Cost Pachete Retinere</label>
	              			</div>
              			</div>
              			
              			<div class="row">
	              			<div class="input-field col s6">
				                <input id="micadj" type="number" name="micadj" class="validate" value="<?php echo $micadj ?>">
				                <label for="micadj" class="active">Cost D-J Casuta Mica</label>
	              			</div>
	              			<div class="input-field col s6">
				                <input name="micavs" id="micavs" type="number" value="<?php echo $micavs ?>" class="validate">
				                <label for="micavs" class="active">Cost V-S Casuta Mica</label>
	              			</div>
              			</div>

						<div class="row">
	              			<div class="input-field col s6">
					                <input id="mediedj" type="number" name="mediedj" value="<?php echo $mediedj ?>" class="validate">
					                <label for="mediedj" class="active">Cost D-J Casuta Medie</label>
	              			</div>
	              			<div class="input-field col s6">
					                <input name="medievs" id="medievs" type="number" value="<?php echo $medievs ?>" class="validate">
					                <label for="medievs" class="active">Cost V-S Casuta Medie</label>
	              			</div>
              			</div>

						<div class="row">
	              			<div class="input-field col s6">
					                <input id="maredj" type="number" name="maredj" value="<?php echo $maredj ?>" class="validate">
					                <label for="maredj" class="active">Cost D-J Casuta Mare</label>
	              			</div>
	              			<div class="input-field col s6">
					                <input name="marevs" id="marevs" type="number" value="<?php echo $marevs ?>" class="validate">
					                <label for="marevs" class="active">Cost V-S Casuta Mare</label>
	              			</div>
              			</div>


              			<div class="row">
	              			<div class="input-field col s6">
					                <input id="viladj" type="number" name="viladj"  value="<?php echo $viladj ?>" class="validate">
					                <label for="viladj" class="active">Cost D-J Camera Vila</label>
	              			</div>
	              			<div class="input-field col s6">
					                <input name="vilavs" id="vilavs" type="number"  value="<?php echo $vilavs ?>" class="validate">
					                <label for="vilavs" class="active">Cost V-S Camera Vila</label>
	              			</div>
              			</div>
              			
              			<div class="row">
							<div class="input-field col s12">
						          <textarea id="textarea1" name="datefirma" class="materialize-textarea"><?php echo $datefirma ?></textarea>
						          <label for="textarea1">Date Firma</label>
				       		</div>
				        </div>
				        <div class="row">
				        		<p class="error-notification" id="errors">Testing</p>
				        </div>
				        <div class="row center-align">
							<input type="submit" class="waves-effect waves-light btn" value="Salveaza Modificarile" name="submit" >
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	.panel-body{
	    padding: 20px 30px;
	    background: #f1f1f1;
    	margin-top: 40px;
	}

	.input-field label{
		color:#252525;
	}
	.input-field label.active{
		font-size: 1rem;
	}

	#errors{
		    color: #a00303;
		    background: #ecc2cd;
		    padding: 10px;
		    border-radius: 5px;
		    text-align: center;
		    display: none;
	}
	#errors.success{
			color: #11655d;
   			background: #a4dad5;
	}
	#errors.display{
		display: block;
	}
</style>
<script type="text/javascript">
	$("#settingsForm").submit(function(e) {

    var url = "/settings/"; // the script where you handle the form input.

    $.ajax({
           type: "POST",
           url: url,
           data: $("#settingsForm").serialize(), // serializes the form's elements.
           success: function(data)
           {
               data= $.parseJSON(data); // show response from the php script.
               $('#errors').addClass('display');
               if(data.status =="success"){
               		$('#errors').addClass('success');
               }else{
               		$('#errors').removeClass('success');	
               }
               $('#errors').html(data.message);	
           }
         });

    	e.preventDefault(); // avoid to execute the actual submit of the form.
	});


</script>
<!--
- cost catch& release
- cost pachete retinere
- cost pe tipuri de cazare ( 4 campuri | cazare vila, cazare casuta mica, cazare casuta medie , cazare casa mare)
- Date firma 
  Textarea cu <br>

<textarea  rows="4" cols="50" name="comment" form="usrform">
					Date firma...</textarea> -->