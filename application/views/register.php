<div class="login" ng-controller="RegistrationCtrl">
	<div class="center-align">
		<a href="/program" ><img class="responsive-img" style="width: 180px; margin-bottom: 20px;" src="/wp-content/uploads/2016/06/logo.png"></a>
	</div>
	<div class="container">
		<div class="card grey lighten-4 row">
			<h5 class="black-text center-align">Înregistrare cont</h5>
			<form class="col s12" method="POST" id="registerForm" ng-submit=register()>
				<div id="card-alert" class="card pink lighten-5" ng-show="error.register" ng-class="{'green': error.confirm }">
					<div class="card-content pink-text darken-1"  ng-class="{'green-text': error.confirm }">
						<p id="responseRegister" ng-bind = error.registerMessage></p>
					</div>
					<button type="button" class="close pink-text" data-dismiss="alert" aria-label="Close" ng-click="error.register=false">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class='row'>
					<div class='input-field col s12'>
						<input class='validate' type='text' name='nume' id='nume' ng-model="user.nume"/>
						<label for='nume'>Nume</label>
					</div>
				</div>
				<div class='row'>
					<div class='input-field col s12'>
						<input class='validate' type='email' name='email' id='email' ng-model="user.email"/>
						<label for='email'>Email</label>
					</div>
				</div>
				<div class='row'>
					<div class='input-field col s12'>
						<input class='validate' type='password' name='password' id='password' ng-model="user.parola"/>
						<label for='password'>Parolă</label>
					</div>
				</div>
				<div class='row'>
					<div class='input-field col s12'>
						<input class='validate' type='tel' name='telefon' id='telefon' ng-model="user.telefon"/>
						<label for='email'>Telefon</label>
					</div>
				</div>
				<div class='row'>
					<button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect orange'>Înregistreză-te</button>
				</div>
			</form>
		</div>
	</div>
	<p class="center-align white-text">Ai deja cont? Intră <a href="/program/core/login" class="orange-text text-lighten-1">aici</a>.</p>
</div>

