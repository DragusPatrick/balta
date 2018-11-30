<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo isset($page['title']) ? $page['title'] : 'Reserve'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="index, follow, noodp" />

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">


    <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css'>
    <link rel='stylesheet' type='text/css' href="/assets/vendor/mpf.css">
    <link rel='stylesheet' type='text/css' href='/assets/style.css'>

    <link rel='stylesheet' type='text/css' href="/assets/vendor/magnific/magnific-popup.css">


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-materialize/0.2.1/angular-materialize.min.js"></script>



    <script type="text/javascript">
        var base_url = '<?php echo base_url(); ?>';
    </script>
</head>
<body ng-app="fishApp" ng-controller="MainCtrl" ng-init="init(<?php echo isset($loggedIn) ? $loggedIn : false; ?>)">
<?php $this->load->view('header') ?>
<?php echo isset($page['content']) ? $page['content'] : ''; ?>

<script type="text/javascript" src="/assets/Controllers/MainCtrl.js"></script>
<script type="text/javascript" src="/assets/Controllers/SearchCtrl.js"></script>

<?php if(isset($loggedIn) && ($loggedIn==true)) : ?>
    <script type="text/javascript" src="/program/assets/app-on.js"></script>
<? else : ?>
    <script type="text/javascript" src="/assets/app-off.js"></script>
    <script type="text/javascript" src="/assets/Controllers/LoginCtrl.js"></script>
    <script type="text/javascript" src="/assets/Controllers/RegistrationCtrl.js"></script>

<? endif; ?>

<div class="spinner" ng-show="spinnerActive==true">
    <img src="/assets/images/search_spinner.gif" />
</div>

<script type="text/javascript" src="/assets/vendor/bootbox.min.js"></script>

<script type="text/javascript" src="/assets/vendor/magnific/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<!--<script type="text/javascript" src="/assets/data-tables.js"></script>-->
<script type="text/javascript" src="/assets/vendor/form.min.js"></script>

</body>
</html>