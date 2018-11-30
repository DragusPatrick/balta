fishApp.controller('SearchCtrl', function($scope,$filter,$timeout) {

    $scope.spot = {
        cazare : "",
        checkin: "",
        checkout:"",
        locuri: [],
        zileSelectate:[],
        zs:{}, // zile Selectate array of objects
        tipCazareSelectat:0,
        selectedSpot:0,
        pachet:0,
        ps:[],
        total: 0,
        tct:{},
        DJ:0, //Duminica - Joi
        VS:0, //Vineri - Sambata
        CR:0, //Catch & Release
        RC:0,  //Retinere Crap
        comment: 'No Comment'
    };


    $scope.tip_cazare=[];
    $scope.tip_cazare[0] = "fara cazare";
    $scope.tip_cazare[1] = "Cazare tip casă mică";
    $scope.tip_cazare[2] =  "Cazare tip casă medie";
    $scope.tip_cazare[3] =  "Cazare tip casă mare";

    $scope.tip_cazare_cost = [];
    $scope.tip_cazare_cost[0] =  {DJ : 0   , VS: 0   };
    $scope.tip_cazare_cost[1] =  {DJ : 120 , VS: 160 };
    $scope.tip_cazare_cost[2] =  {DJ : 140 , VS: 180 };
    $scope.tip_cazare_cost[3] =  {DJ : 180 , VS: 200 };

    $scope.costCazare =0;

    $scope.program=[];
    $scope.program[0] = "18:00 - 17:00";
    $scope.program[1] = "06:00 - 18:00";
    $scope.program[2] = "18:00 - 06:00";
    $scope.program[3] = "Rezervat";

    $scope.pachet=[];
    $scope.pachet[1] =  50; // Catch & Release 12h
    $scope.pachet[2] =  100; // Retinere Crap 12h

    $scope.error ={
        spot : false,
        spotMessage : ""
    };

    $scope.step  = 1;


    $scope.init = function(costcr,costrc,micadj,micavs,mediedj,medievs,maredj,marevs,viladj,vilavs){
        $scope.tip_cazare_cost[0] =  {DJ : 0   , VS: 0   }; // fara cazare 
        $scope.tip_cazare_cost[1] =  {DJ : micadj , VS: micavs };   // 120 - 160
        $scope.tip_cazare_cost[2] =  {DJ : mediedj , VS: medievs }; // 140 - 180
        $scope.tip_cazare_cost[3] =  {DJ : maredj , VS: marevs };   // 160 - 200
        $scope.tip_cazare_cost[4] =  {DJ : viladj , VS: vilavs };   // 120 - 160 

        $scope.pachet[1] =  costcr; // Catch & Release 12h
        $scope.pachet[2] =  costrc; // Retinere Crap 12h
    }

    $scope.setStep = function (newStep) {
        if (newStep == 1) {
            $scope.step = 1;

            return;
        }
        if (newStep == 2) {


            if(angular.element('#checkin').val() &&  angular.element('#checkout').val()
            && $scope.spot.cazare) {
                $scope.spot.checkin = new  Date(angular.element('#checkin').val());
                $scope.spot.checkout = new  Date(angular.element('#checkout').val());
                $scope.step = 2;

                $scope.cauta();
            }else{
                alert('Completati toate datele formularului');
            }

            return;
        }
    };

    //Function  Step 1 -> Step 2
    $scope.cauta = function(){
        $scope.$parent.spinnerActive = true;
        if ($scope.spot.cazare && $scope.spot.checkin && $scope.spot.checkout){

            $.ajax({
                url     : '/core/check_spots_ajax',
                data    : {
                    cazare  : $scope.spot.cazare,
                    checkin :  $filter('date')($scope.spot.checkin, "yyyy-MM-dd"),
                    checkout :  $filter('date')($scope.spot.checkout, "yyyy-MM-dd")
                },
                dataType: 'json',
                type    : 'GET',
                success : function(response){

                    $scope.spot.locuri = response;

                }
            });
        }
        else{
            $scope.error.spot = true;
            $scope.error.spotMessage = "Invalid data, please complete the fields corectly!";
        }
        $timeout(function () {
            $scope.$parent.spinnerActive = false;
        },1500);

    };

    //Function Step 2 -> Step 3
    $scope.getPacket = function(loc_id){
        $scope.$parent.spinnerActive = true;
        if(loc_id == $scope.spot.selectedSpot){
            $scope.step = 3;

            //Zile selectate
            $scope.spot.zileSelectate= angular.element("input[type='checkbox']:checked[name='rezerva"+ $scope.spot.selectedSpot+"'");

            angular.forEach($scope.spot.zileSelectate, function(value, key) {
                $scope.temp=value.value;
                if($scope.spot.cazare == 1){
                    //Cu Cazare
                    $scope.temp= $scope.temp.replace("#1","");
                    $scope.spot.zs[$scope.temp] = 0;
                }else {

                    //Fara Cazare

                    //Partea de zi
                    if ($scope.temp.indexOf("#1") != -1) {
                        $scope.temp = $scope.temp.replace("#1", "");
                        $scope.spot.zs[$scope.temp] =1

                    }

                    //Partea de noapte
                    if ($scope.temp.indexOf("#2") != -1) {
                        $scope.temp = $scope.temp.replace("#2", "");

                        if($scope.spot.zs[$scope.temp] != undefined ){
                            $scope.spot.zs[$scope.temp]= $scope.spot.zs[$scope.temp] +2;
                        }else{
                            $scope.spot.zs[$scope.temp] = 2;
                        }
                    }

                }
            });


            //Loc Selectat
            console.log("Loc Selectat: " + $scope.spot.selectedSpot);

            // Zile selectate
            console.log("Zile selectate" + $scope.spot.zileSelectate);

        }else{
            alert('Invalid Data');
        }
        $timeout(function () {
            $scope.$parent.spinnerActive = false;
        },1000);
    };



    //Function Step 3 -> Step 4
    $scope.getDataReserve = function (loc_id) {

        $scope.$parent.spinnerActive = true;
        $scope.step = 4;

        //Zile selectate
        //$scope.spot.pacheteSelectate= angular.element("input[type='checkbox']:checked[name='rezerva"+ $scope.spot.selectedSpot+"'");

        angular.forEach($scope.spot.zs, function(value,key) {
            $scope.tempZi = 0;
            $scope.tempNo = 0;
            console.log("This is the Key " + key );
            if($scope.spot.cazare == 1){
                $scope.tempZi = angular.element("input[name='pachetZi#" + key +"']:checked").val();
                $scope.tempNo = angular.element("input[name='pachetNo#" + key +"']:checked").val();

            }else {
                if(value != 2){
                    $scope.tempZi = angular.element("input[name='pachetZi#" + key +"']:checked").val();
                }
                if(value != 1){
                    $scope.tempNo = angular.element("input[name='pachetNo#" + key +"']:checked").val();
                }
            }

            $scope.spot.ps[key] = {
                Zi : $scope.tempZi,
                No : $scope.tempNo
            };
        });


        // Cazare
        console.log("Cazare: " + $scope.spot.cazare);

        // Tip Cazare
        console.log("Tip Cazare: " + $scope.spot.tipCazareSelectat);

        //Loc Selectat
        console.log("Loc Selectat: " + $scope.spot.selectedSpot);

        // Zile selectate
        console.log($scope.spot.zs);

        // Pachet pe zile
        console.log($scope.spot.ps);

        $scope.calculTotal();

        $timeout(function () {
            $scope.$parent.spinnerActive = false;
        },1000);
    };




    $scope.setActive = function (id,tipCazareSelectat) {
        if($scope.spot.selectedSpot == id){
            $scope.spot.selectedSpot =0;
            $scope.spot.tipCazareSelectat = 0;
        }
        else{
            $scope.spot.selectedSpot =id;
            $scope.spot.tipCazareSelectat = tipCazareSelectat;
        }
        angular.element("#tipCazareSelectat").html($scope.tip_cazare[tipCazareSelectat]);
    };
    
    // Date informative :
    // Cazare:   valoarea 0 - fara cazare, valoarea 1 - cu cazare
    // Pachet:   valoarea 1 - Catch & Release , valoarea 2 - Retinere 5kg Crap
    // Tip Cazare - 0 fara cazare, 1 casa mica , 2 casa medie, 3 casa mare

    // Calculate Total Cost
    $scope.calculTotal = function () {

        $scope.total = 0;

        // If cazare
        if($scope.spot.cazare == 1){
            $scope.eliminate = 1;

            angular.forEach($scope.spot.zs, function (value, key) {
                $scope.temp = new Date(key);
                $scope.tempP = 0;

                if ($scope.temp.getDay() == 5 || $scope.temp.getDay() == 6) {
                    $scope.spot.VS = $scope.spot.VS + 1;
                } else {
                    $scope.spot.DJ = $scope.spot.DJ + 1;
                }

                $scope.tempPs = $scope.spot.ps[key];


                $scope.tempP = $scope.tempP + $scope.pachet[$scope.tempPs.Zi];
                $scope.tempP = $scope.tempP + $scope.pachet[$scope.tempPs.No];

                $scope.incrementPachet($scope.tempPs.Zi);
                $scope.incrementPachet($scope.tempPs.No);

                $scope.total = $scope.total + $scope.tempP;
                //$scope.eliminate = $scope.eliminate +1 ;
            });

            $scope.costCazare =  $scope.spot.VS * $scope.tip_cazare_cost[$scope.spot.tipCazareSelectat].VS +  $scope.spot.DJ * $scope.tip_cazare_cost[$scope.spot.tipCazareSelectat].DJ;

            //Vineri - Sambata
            console.log("This is cost Cazare VS: " + $scope.spot.VS);
            console.log("Cost cazare VS Tip Cazare: " + $scope.tip_cazare_cost[$scope.spot.tipCazareSelectat].VS);

            //Duminica - Joi
            console.log("This is cost Cazare DJ: " + $scope.spot.DJ);
            console.log("Cost cazare VS Tip Cazare: " + $scope.tip_cazare_cost[$scope.spot.tipCazareSelectat].DJ);


            console.log("This is cost Cazare: " + $scope.costCazare);
            console.log("This is pachet Cost: " + $scope.total);
            $scope.total = $scope.total + $scope.costCazare;

        }
        //Not with cazare
        else {
            angular.forEach($scope.spot.zs, function (value, key) {
                $scope.tempPs = $scope.spot.ps[key];
                console.log("Pachet zi " + $scope.tempPs.Zi);
                console.log("Pachet no " + $scope.tempPs.No);



                if($scope.tempPs.Zi != 0){
                    $scope.total = $scope.total + $scope.pachet[$scope.tempPs.Zi];
                    $scope.incrementPachet($scope.tempPs.Zi);
                }

                if($scope.tempPs.No != 0){
                    $scope.total = $scope.total + $scope.pachet[$scope.tempPs.No];
                    $scope.incrementPachet($scope.tempPs.No);
                }
            });
        }

        $scope.spot.total = $scope.total;
        console.log("Totalul este:" + $scope.total);
    };

    //Function For Confirm Rezervation :: Final Step
    $scope.confirmareRezervare = function () {
        $.ajax({
            url     : '/core/confirmareRezervare_ajax',
            data    : {
                cazare  : $scope.spot.cazare,
                loc  : $scope.spot.selectedSpot,
                pachet  : $scope.spot.pachet,
                cost  : $scope.spot.total,
                comment : $scope.spot.comment,
                zile: $scope.spot.zs,
                nrcr: $scope.spot.CR,
                nrrc: $scope.spot.RC,
                costcazare: $scope.costCazare,
                perioada: $('#perioadaHtml').html()                
            },
            dataType: 'json',
            type    : 'POST',
            success : function(response){
                console.log(response);
                alert('Rezervare Confirmata! O sa fiti redirectionat inapoi la pagina de Acasa, Va multumim!');
                setTimeout(function () {
                    location.reload();
                },3000);
            }
        });
    };


    //Function for get value for Pachet
    $scope.incrementPachet = function(value){
        if(value == 1){
            $scope.spot.CR = $scope.spot.CR + 1;
        }else{
            $scope.spot.RC = $scope.spot.RC + 1;
        }
    }
});

