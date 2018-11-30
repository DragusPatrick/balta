fishApp.controller('RegistrationCtrl', function($scope,$timeout) {

    $scope.user = {
        nume : "",
        email : "",
        parola: "",
        telefon:""

    };

    $scope.error ={
        register : false,
        registerMessage : "",
        confirm : false
    };

    $scope.register = function(){
        $scope.$parent.spinnerActive = true;
        if ($scope.user.email && $scope.user.parola && $scope.user.telefon && $scope.user.nume){

            $.ajax({
                url     : '/core/register_ajax',
                data    : {
                    nume : $scope.user.nume,
                    mail  : $scope.user.email,
                    parola :  $scope.user.parola,
                    telefon :  $scope.user.telefon
                },
                dataType: 'json',
                type    : 'POST',
                success : function(response){
                    console.log(response);

                    $scope.error.register = true;
                    $scope.error.registerMessage = response.message;
                    $scope.$apply();

                    if(response.type == "success"){
                        $scope.error.confirm = true;
                        $scope.$apply();

                        $timeout(function () {
                            window.location = "/core/login";
                        },2000);
                    }

                }
            });
        }
        else{
            $scope.error.register = true;
            $scope.error.registerMessage = "Invalid data, please complete the fields correctly!";

        }
        $scope.$parent.spinnerActive = false;

    }

});