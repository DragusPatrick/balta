<div class="login" ng-controller="LoginCtrl">
    <div class="center-align">
        <a href="/program" ><img class="responsive-img" style="width: 180px; margin-bottom: 20px;" src="/wp-content/uploads/2016/06/logo.png"></a>
    </div>
    <div class="container">
        <div class="card grey lighten-4 row">
            <h5 class="black-text center-align">Logare în cont</h5>
            <form class="col s12" method="POST" id="loginForm" ng-submit=login()>
                <div id="card-alert" class="card pink lighten-5" ng-show="error.login">
                    <div class="card-content pink-text darken-1">
                        <p id="responseLogin" ng-bind = error.loginMessage></p>
                    </div>
                    <button type="button" class="close pink-text" data-dismiss="alert" aria-label="Close" ng-click="error.login=false">
                        <span aria-hidden="true">×</span>
                    </button>
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
                    <button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect green'>Login</button>
                </div>
            </form>
        </div>
    </div>
    <p class="center-align white-text">Nu ai cont? <a href="register" class="orange-text text-lighten-1">Înregistrează-te!</a></p>
</div>
