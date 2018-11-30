fishApp.controller('LoginCtrl', function($scope) {

    $scope.user = {
        email : "",
        parola: ""
    };

    $scope.error ={
        login : false,
        loginMessage : ""
    };

    $scope.login = function(){
        $scope.$parent.spinnerActive = true;

        if ($scope.user.email && $scope.user.parola){
            $.ajax({
                url     : '/core/login_ajax',
                data    : {
                    mail  : $scope.user.email,
                    parola :  $scope.user.parola
                },
                dataType: 'json',
                type    : 'POST',
                success : function(response){
                    console.log(response);

                    if(response.type == "danger"){
                        $scope.error.login = true;
                        $scope.error.loginMessage = response.message;
                        $scope.$apply();

                    }else{
                        if(response.type == "success"){
                            window.location = "/core/";
                        }
                    }

                }
            });
        }
        else{
            $scope.error.login = true;
            $scope.error.loginMessage = "Invalid data, please complete the fields corectly!";
        }
        $scope.$parent.spinnerActive = false;

    }

});