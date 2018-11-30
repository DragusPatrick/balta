
<div class="navbar-fixed">
	<nav class="solacolu grey-text text-darken-4" role="navigation">
		<div class="nav-wrapper" style="margin-left: 20px; margin-right: 20px;">
			<a id="logo-container" href="#" class="" style="top: -0.3rem;">
				<img src="/wp-content/uploads/2016/06/logo.png" style="height: 50px; vertical-align: middle; margin-top: -7px;"></a>
			
			<ul class="right hide-on-small-only">
				<?php if ($loggedIn) : ?>
					Bine ai venit!
					<li><a href="/core/logout" class="btn waves-effect green white-text">Logout</a></li>
				<?php else : ?>
					<li><a href="/core/login" class="btn waves-effect green white-text">Log In</a></li>
					<li><a href="/core/register" class="btn waves-effect orange white-text" style="margin-left: 10px;">Înregistreză-te</a></li>
				<?php endif ?>
			
			</ul>
			
			<ul id="nav-mobile" class="side-nav" style="width: 280px; left: -28010px;">
				<?php if ($loggedIn) : ?>
					Bine ai venit!
					<li><a href="/core/register" class="green-text waves-effect text-darken-3">Logout<</a></li>
				<?php else : ?>
					<li><a href="/core/register" class="green-text waves-effect text-darken-3">Înregistreză-te<</a></li>
					<li><a href="/core/login" class="orange-text waves-effect text-darken-3">Login</a></li>
				<?php endif ?>
			</ul>
			<!--<a href="#" data-activates="nav-mobile" class="button-collapse right hide-on-med-and-up"><i class="material-icons white-text">menu</i></a>-->
		</div>
	</nav>
</div>
<div class="container rezervare" ng-controller="SearchCtrl">
	<form method="POST" id="searchForm" ng-submit=cauta()>
		<h4 class="center-align">Formular de rezervare</h4>
		<div ng-show="step==1" class="card grey lighten-4 row">
			<div class="col s12">
				<div class="row no-margin">
					<div class="input-field col s12 m6 dateField">
						<i class="material-icons prefix">date_range</i>
						<input
							type="date"
							class="datepicker"
							id="checkin"
							required
							ng-model="spot.checkin"
							name="checkin"
						>
						<label for="icon_prefix">Selectează perioada</label>
					</div>
					<div class="input-field col s12 m6 dateField">
						<i class="material-icons prefix">date_range</i>
						<input
							type="date"
							class="datepicker"
							id="checkout"
							name="checkout"
						>
						<label for="icon_prefix">Selectează perioada</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s6 m4 l3 radioField">
						<input
							class="with-gap"
							name="cazare"
							type="radio"
							ng-model="spot.cazare"
							value="1"
							id="cazare1"
						/>
						<label for="cazare1">Doresc cazare</label>
					</div>
					<div class="input-field col s6 m4 l3 radioField">
						<input
							class="with-gap"
							name="cazare"
							type="radio"
							ng-model="spot.cazare"
							id="cazare0"
							value="0"
							checked />
						<label for="cazare0">Nu doresc cazare</label>
					</div>
				</div>
				<div class="row">
					<div class="col s12 m3 offset-m9 l2 offset-l10">
						<button  name='btn_next' class='btn btn waves-effect right green' ng-click="setStep(2)">Continuă</button>
					</div>
				</div>
				<hr>
				<blockquote>
					<ul>
						<li>Rezervarea pe 24 ore, cu cazare, se face Începând cu ora 18:00 până la ora 18:00 a doua zi. </li>
						<li>Rezervarea pe 24 ore, cu cazare, se face Începând cu ora 18:00 până la ora 18:00 a doua zi. </li>
						<li>Rezervarea pe 24 ore, cu cazare, se face Începând cu ora 18:00 până la ora 18:00 a doua zi. </li>
					</ul>
				</blockquote>
			</div>
		</div >
		<div ng-show="step==2" class="card grey lighten-4 row" >
			
			<div class="row">
				<ul class="collapsible" data-collapsible="accordion" watch>
					<li ng-repeat="loc in spot.locuri">
						<div class="collapsible-header ">
							<ul class="collection">
								<li class="collection-item avatar">
									<img src="/assets/images/casa-{{loc.tip_casa}}.jpg" alt="" class="circle">
									<span class="title">Locul # {{loc.id}} </span>
									<p>{{ tip_cazare[loc.tip_casa]}}</p>
									<p>Disponibil pe perioada selectată.</p>
								</li>
							</ul>
						</div>
						<div class="collapsible-body">
							<div class="row">
								<div class="col s12">
									<ul id="task-card" class="collection day" ng-repeat="(key, value) in loc.zile">
										<li class="collection-header cyan">
											<p class="task-card-date">{{ key }}</p>
										</li>
										
										<li class="collection-item dismissable" ng-if="value == 0 ">
											<input type="checkbox" value="{{key}}" name="rezerva{{ loc.id }}" ng-if="spot.cazare == 1">
											<input type="checkbox" value="{{key}}#1" name="rezerva{{ loc.id }}" ng-if="spot.cazare == 0">
											<label style="text-decoration: line-through;">
												<a href="#" class="secondary-content">
													<span class="ultra-small" ng-if="spot.cazare = 1">{{ program[0] }}</span>
													<span class="ultra-small" ng-if="spot.cazare = 0">{{ program[1] }}</span>
												</a>
											</label>
										</li>
										<li class="collection-item dismissable" ng-if="value == 1">
											<input type="checkbox" name="rezerva{{ loc.id }}" value="{{key}}#2" >
											<label for="day01-half02" style="text-decoration: none;">
												<a href="#" class="secondary-content">
													<span class="ultra-small" ng-if="spot.cazare = 0">{{ program[2] }}</span>
												</a>
											</label>
										</li>
									</ul>
								
								</div>
							</div>
						</div>
					</li>
				
				</ul>
				<script>
					$(document).ready(function(){
						$('.collapsible').collapsible();
					});
				</script>
			</div>
			
			<div class="row">
				<div class="col s12 m3 offset-m9 l2 offset-l10">
					<button type='submit' name='btn_next' class='btn btn waves-effect right green' ng-click="step=3">Continuă</button>
				</div>
			</div>
			
			<hr>
			<blockquote>
				<ul>
					<li>Rezervarea pe 24 ore, cu cazare, se face Începând cu ora 18:00 până la ora 18:00 a doua zi. </li>
					<li>Rezervarea pe 24 ore, cu cazare, se face Începând cu ora 18:00 până la ora 18:00 a doua zi. </li>
					<li>Rezervarea pe 24 ore, cu cazare, se face Începând cu ora 18:00 până la ora 18:00 a doua zi. </li>
				</ul>
			</blockquote>
		</div>
	</form>
</div>
