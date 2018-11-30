<div class="navbar-fixed">
    <nav class="solacolu grey-text text-darken-4" role="navigation">
        <div class="nav-wrapper" style="margin-left: 20px; margin-right: 20px;">
<!--            <a id="logo-container" href="#" class="" style="top: -0.3rem;"><img src="http://solacolu.brandsuit.ro/wp-content/uploads/2016/06/logo.png" style="height: 50px; vertical-align: middle; margin-top: -7px;"></a>-->

            <ul class="right top-actions">
                <?php if ($loggedIn) : ?>
                    <p class="left">Bine ai venit!</p>
                    <?php if($this->user->is_admin()){ ?>
			                     <li><a href="/dashboard" class="btn waves-effect orange white-text">Dashboard</a></li>
                    <?php  } ?>

                    <li class="right"><a href="/core/logout" class="btn waves-effect green white-text">Logout</a>
                    </li>
                <?php else : ?>
                    <li><a href="/core/login" class="btn waves-effect green white-text">Log In</a></li>
                    <li><a href="/core/register" class="btn waves-effect orange white-text"
                           style="margin-left: 10px;">Înregistreză-te</a></li>
                <?php endif ?>

            </ul>

            <ul id="nav-mobile" class="side-nav top-actions" style="width: 280px; left: -28010px;">
                <?php if ($loggedIn) : ?>
                    Bine ai venit!
			                    <?php if($this->user->is_admin()){ ?>
			                     <li><a href="/dashboard" class="green-text waves-effect text-darken-3">Dashboard</a></li>
			                    <?php  } ?>
                    <li><a href="/core/register" class="green-text waves-effect text-darken-3">Logout</a></li>
                <?php else : ?>
                    <li><a href="/core/register"
                           class="green-text waves-effect text-darken-3">Înregistreză-te<</a></li>
                    <li><a href="/core/login" class="orange-text waves-effect text-darken-3">Login</a></li>
                <?php endif ?>
            </ul>
           <!--  <a href="#" data-activates="nav-mobile" class="button-collapse right hide-on-med-and-up"><i class="material-icons white-text">menu</i></a> -->
        </div>
    </nav>
</div>
<div class="container rezervare" 
     ng-controller="SearchCtrl" 
     ng-init="init(<?php echo $configs['costcr']?>,<?php echo $configs['costrc']?>,<?php echo $configs['micadj']?>,<?php echo $configs['micavs']?>,<?php echo $configs['mediedj']?>,<?php echo $configs['medievs']?>,<?php echo $configs['maredj']?>,<?php echo $configs['marevs']?>,<?php echo $configs['viladj']?>,<?php echo $configs['vilavs']?>)">
    <form method="POST" id="searchForm">
        <h4 ng-show="step==1 || step==2" class="center-align">Formular de rezervare</h4>
        <h4 ng-show="step==3" class="center-align">Confirmare rezervare</h4>

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
                        <label for="icon_prefix">Dată sosire</label>
                    </div>
                    <div class="input-field col s12 m6 dateField">
                        <i class="material-icons prefix">date_range</i>
                        <input
                            type="date"
                            class="datepicker"
                            id="checkout"
                            name="checkout"
                            >
                        <label for="icon_prefix">Dată plecare</label>
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
                        <label for="cazare1">Doresc cazare*</label>
                    </div>
                    <div class="input-field col s6 m4 l3 radioField">
                        <input
                            class="with-gap"
                            name="cazare"
                            type="radio"
                            ng-model="spot.cazare"
                            id="cazare0"
                            value="0"
                            checked/>
                        <label for="cazare0">Nu doresc cazare</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m3 offset-m9 l2 offset-l10">
                        <button name='btn_next' class='btn btn waves-effect right green' ng-click="setStep(2)">
                            Continuă
                        </button>
                    </div>
                </div>
                <hr>
                <?php $this->load->view("disclaimer"); ?>
            </div>
        </div>
        <div ng-show="step==2" class="card grey lighten-4 row">
            <div class="col s12 locations-balta">
                <a href="/assets/images/locatii-balta.png" target="_BLANK">
                    <img src="/assets/images/locatii-balta.png" alt="" class="responsive-img" style="width: 100%;border-radius: 5px;padding-top: 10px;"></a>
            </div>
            <div class="col s12">
                <div class="row">
                    <ul class="collapsible" data-collapsible="accordion" watch style="margin: 10px;">
                        <li ng-repeat="loc in spot.locuri">
                            <div class="collapsible-header" ng-click="setActive(loc.id,loc.tip_casa)">
                                <ul class="collection">
                                    <li class="collection-item avatar">
                                        <img src="/assets/images/casa-{{loc.tip_casa}}.jpg" alt="" class="circle">
                                        <span class="title"><strong>Locul # {{loc.id}}</strong></span>

                                        <p>{{ tip_cazare[loc.tip_casa]}} - {{loc.descriere}} </p>

                                        <p>Disponibil pe perioada selectată.</p>
                                        <i class="material-icons right" style="">expand_more</i>
                                    </li>
                                </ul>
                            </div>
                            <div class="collapsible-body">
                                <div class="row notes" ng-if="spot.cazare != 1">
                                    <div class="col s12">
                                        <p style="color: red;font-weight: bold;">*Pachetul de Noapte ( 18:00 - 06:00 ) este valabil doar cu pescuitul de zi din ziua urmatoare.*</p>
                                        <ul>
                                            <li style="color: red;font-weight: bold;"> Doar Pachete in intervalul  18:00 - 18:00 </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col s12">


                                        <ul id="task-card" class="collection day" ng-repeat="(key, value) in loc.zile">
                                            <li class="collection-header cyan">
                                                <p class="task-card-date">{{ key }}</p>
                                            </li>
                                            <?php if ($loggedIn) : ?>
                                                <li class="collection-item dismissable" ng-class="{'indisponibil':  value == 1 || value == 3}">
                                            <?php else : ?>
                                                <li class="collection-item dismissable notLoggedIn" ng-class="{'indisponibil':  value == 1 || value == 3}">
                                            <?php endif ?>

                                                <input type="checkbox" value="{{key}}#1" id="{{ loc.id }}#{{key}}#1"
                                                       name="rezerva{{ loc.id }}" ng-if="spot.cazare == 1">
                                                <input type="checkbox" value="{{key}}#1" id="{{ loc.id }}#{{key}}#1"
                                                       name="rezerva{{ loc.id }}" ng-if="spot.cazare == 0">
                                                <label for="{{ loc.id }}#{{key}}#1">
                                                    <a onclick="javascript:void(0)" class="secondary-content">
                                                        <span class="ultra-small" ng-if="spot.cazare == 1 && value != 1">{{ program[0] }}</span>
                                                        <span class="ultra-small"
                                                              ng-if="spot.cazare == 0 && (value == 0 || value == 2)">{{ program[1] }}</span>
                                                        <span class="ultra-small"
                                                              ng-if=" value == 1 || value == 3">{{ program[3] }}</span>
                                                    </a>
                                                </label>
                                            </li>
    
                                            <?php if ($loggedIn) : ?>
                                                <li class="collection-item dismissable" ng-if="spot.cazare == 0"
                                                    ng-class="{'indisponibil':value == 2 || value == 3}">
                                                <?php else : ?>
                                                <li class="collection-item dismissable notLoggedIn" ng-if="spot.cazare == 0"
                                                    ng-class="{'indisponibil':value == 2 || value == 3}">
                                            <?php endif ?>
                                                
                                                <input type="checkbox" name="rezerva{{ loc.id }}" value="{{key}}#2"
                                                       id="{{ loc.id }}#{{key}}#2">
                                                <label for="{{ loc.id }}#{{key}}#2">
                                                    <a onclick="javascript:void(0)" class="secondary-content">
                                                        <span class="ultra-small"
                                                              ng-if="spot.cazare == 0 && value != 2 && value != 3 ">{{ program[2] }}</span>
                                                        <span class="ultra-small"
                                                              ng-if="spot.cazare == 0 && (value == 2 || value == 3)">{{ program[3] }}</span>
                                                    </a>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
    
                                <div class="row notes" ng-if="loc.tip_casa == 3">
                                    <div class="col s12">
                                        <p>*Casele mari au 2 locuri de pescuit aferente.Locul 2 este optional si  se plateste separat la fata locului.</p>
                                    </div>
                                </div>
                                
                               
                                
                                <div class="row no-margin">
                                    <div class="col s12 m3 l2">
                                        <button name="btn_next" class="btn btn waves-effect left orange"
                                                ng-click="setStep(1)">Înapoi
                                        </button>
                                    </div>
                                    
                                    <div class="col s12 m3 offset-m6 l2 offset-l8">
                                        <?php if ($loggedIn) : ?>
                                            <button name="btn_next" class="btn btn waves-effect right green"
                                                    ng-click="getPacket( loc.id )">Continuă
                                            </button>
                                        <?php else : ?>
                                            <a href="#modal-must-login" name="btn_next"
                                               class="btn btn waves-effect right green">Continuă</a>
                                        <?php endif ?>
                                    </div> 
                                    
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div id="modal-must-login" class="modal modal-fixed-footer">
                    <div class="modal-content">
                        <p>Pentru a putea continua rezervarea trebuie să vă faceți un cont, sau dacă aveți unul deja, să
                            vă logați.</p>
                    </div>
                    <div class="modal-footer">
                        <a href="/core/login" class="btn waves-effect green white-text">Log In</a>
                        <a href="/core/register" class="btn waves-effect orange white-text"
                           style="margin-left: 10px;">Înregistreză-te</a>
                    </div>
                </div>
                <hr>
                <?php $this->load->view("disclaimer"); ?>
            </div>
        </div>
        
        <?php if ($loggedIn) : ?>
            
            <div ng-show="step==3" class="card grey lighten-4 row">
                <div class="col s12">
                    <div class="row">
                        <ul class="collapsible collapsed" data-collapsible="accordion" watch style="margin: 10px;">
                            <li>
                                <div class="collapsible-header active">
                                    <ul class="collection">
                                        <li class="collection-item avatar">
                                            <img src="/assets/images/casa-{{spot.tipCazareSelectat}}.jpg" alt="" class="circle">
                                            <span class="title"><strong>Locul # {{ spot.selectedSpot }}</strong></span>
                                    
                                            <p>{{ tip_cazare[spot.tipCazareSelectat]}}</p>
                                            <i class="material-icons right" style="">expand_more</i>
                                        </li>
                                    </ul>
                                </div>
                                <div class="collapsible-body">
                                    <div class="row">
                                        <div class="col s12">
                                            <ul id="task-card" class="collection days" ng-repeat="(key,value) in spot.zs">
                                                
                                                <!-- Daca are cazare in prima zi ii vom arata doar pescuit noapte iar in ultima zi doar pescuit zi -->
                                                <li class="group-pachete-day collection-header cyan"><p>ZIUA {{ key }} -- {{ value }}</p></li>
                                                <li ng-if="value != 2" class="col s12 group-pachete collection-item">
                                                    <p>Pachet de pescuit Zi :</p>
                                                    <div class="input-field col s12 m4 l3 radioField">
                                                        <input
                                                            class="with-gap"
                                                            name="pachetZi#{{key}}"
                                                            type="radio"
                                                            value="1"
                                                            id="{{key}}#pachetZi1"
                                                            checked
                                                        />
                                                        <label for="{{key}}#pachetZi1">Catch & Release</label>
                                                    </div>
                                                    <div class="input-field col s12 m4 l3 radioField">
                                                        <input
                                                            class="with-gap"
                                                            name="pachetZi#{{key}}"
                                                            type="radio"
                                                            value="2"
                                                            id="{{key}}#pachetZi2"
                                                        />
                                                        <label for="{{key}}#pachetZi2">Reținere 5kg crap</label>
                                                    </div>
                                                </li>
                                                
                                                <li ng-if="value != 1" class="col s12 group-pachete collection-item">
                                                        <p>Pachet de pescuit Noapte :</p>
                                                        <div class="input-field col s12 m4 l3 radioField">
                                                            <input
                                                                class="with-gap"
                                                                name="pachetNo#{{key}}"
                                                                type="radio"
                                                                value="1"
                                                                id="{{key}}#pachetNo1"
                                                                checked
                                                            />
                                                            <label for="{{key}}#pachetNo1">Catch & Release</label>
                                                        </div>
                                                        <div class="input-field col s12 m4 l3 radioField">
                                                            <input
                                                                class="with-gap"
                                                                name="pachetNo#{{key}}"
                                                                type="radio"
                                                                value="2"
                                                                id="{{key}}#pachetNo2"
                                                            />
                                                            <label for="{{key}}#pachetNo2">Reținere 5kg crap</label>
                                                        </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <!-- Buttons -->
                                    <div class="row no-margin">
                                        <div class="col s12 m3 l2">
                                            <button name="btn_next" class="btn btn waves-effect left orange" ng-click="setStep(2)">Înapoi</button>
                                        </div>
                                        <div class="col s12 m3 offset-m6 l2 offset-l8">
                                            <?php if ($loggedIn) : ?>
                                                <button name="btn_next" class="btn btn waves-effect right green" ng-click="getDataReserve()">Continuă</button>
                                            <?php else : ?>
                                                <a href="#modal-must-login" name="btn_next" class="btn btn waves-effect right green">Continuă</a>
                                            <?php endif ?> 
                                            
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="modal-must-login" class="modal modal-fixed-footer">
                        <div class="modal-content">
                            <p>Pentru a putea continua rezervarea trebuie să vă faceți un cont, sau dacă aveți unul deja, să vă logați.</p>
                        </div>
                        <div class="modal-footer">
                            <a href="/core/login" class="btn waves-effect green white-text">Log In</a>
                            <a href="/core/register" class="btn waves-effect orange white-text"
                               style="margin-left: 10px;">Înregistreză-te</a>
                        </div>
                    </div>
                    <hr>
                    <?php $this->load->view("disclaimer"); ?>
                </div>
            </div>

            
            <div ng-show="step==4" class="card grey lighten-4 row">
                <div class="col s12">
                    <div id="invoice">
                        <div class="invoice-table">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <table class="striped">
                                        <thead>
                                            <tr>
                                                <th data-field="" colspan="2">Date personale</th>
                                                <th data-field="" colspan="2"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Nume: </strong></td>
                                                <td><?php echo $user->nume ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email: </strong></td>
                                                <td><?php echo $user->mail ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Telefon: </strong></td>
                                                <td><?php echo $user->telefon ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="striped">
                                        <thead>
                                            <tr>
                                                <th data-field="" colspan="2">Date cazare</th>
                                                <th data-field="" colspan="2"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <!-- Pachete -->
                                            <tr>
                                                <td><strong>Pachete: </strong></td>
                                                <td>
                                                    <ul>
                                                    <li>Nr pachete Catch & Release: {{ spot.CR }} </li>
                                                    <li>Nr pachete Retinere: {{ spot.RC }} </li>
                                                    </ul>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            
                                            
                                            <!-- Cazare -->
                                            <tr>
                                                <td><strong>Cazare: </strong></td>
                                                <td><span id="tipCazareSelectat"></span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Perioadă: </strong></td>
                                                <td>
                                                    <ul id="perioadaHtml">
                                                        <div ng-repeat="(key,value) in spot.zs">
                                                            {{ key }}
                                                            <span ng-show="value == 1"> Pescuit Zi   </span>
                                                            <span ng-show="value == 2"> Pescuit Noapte  </span>
                                                            <span ng-show="value == 3"> Pescuit 24h   </span>
                                                        </div>
                                                    </ul>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr>
	                                            <td><strong>Comentarii: </strong></td>
	                                            <td colspan="3">
		                                           <textarea ng-model="spot.comment" rows="10"></textarea>
	                                            </td>
                                            </tr>
                                            
                                            <tr style="border-top: 2px solid #d0d0d0;">
                                                <td colspan="2"></td>
                                                <td colspan="2"><strong>Total: </strong><span ng-bind="total">{{ total }}</span> RON</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-footer"></div>
                    </div>

                    <div class="row no-margin">
                        <div class="col s12 m3 offset-m9 l2 offset-l10">
                            <button name="btn_next" class="btn btn waves-effect right green" ng-click="confirmareRezervare()">Confirmă</button>
                        </div>
                    </div>
                    <hr>
                    <?php $this->load->view("disclaimer"); ?>
                </div>
            </div>
        <?php endif ?>
    </form>
</div>
