var step=1;
var start_date = new Date();
var end_date = new Date();
var listaCasa = [0,120,140,160];
var partial = 0;
var listaPachet = [
    [0, 'Fara cazare'],
    [50, 'Catch & Release 12h'],
    [100, 'Catch & Release 24h'],
    [100, 'Retinere Crap 5kg 12h'],
    [150, 'Retinere Crap 5kg 24h']
];
var listaDisponibil = ['Disponibil','Disponibil Noaptea','Disponibil Ziua','Indisponibil'];
var program=[
    [ 1,'Program Zi'],
    [2,'Program Noapte'],
    [3, 'Toata Ziua']
];
var programValid;

$(function () {

    $('#registerForm').bind('submit', function () {
        $.ajax({
            type: 'post',
            url: '/core/register_ajax',
            data: $('#registerForm').serialize(),
            success: function(data){
                response = $.parseJSON(data);
                $('#responseRegister').html(response.message);
                $('#responseRegister').addClass(response.type + ' alert');
                if(response.type == 'success'){
                    setTimeout(function(){
                        window.location = '/core/login';
                    }, 2500);
                }

            },
            error: function(data){
                alert('A intervenit o eroare la trimiterea datelor. Va rugam reincarcati pagina');
            }
        });
        return false;
    });

    $('#loginForm').bind('submit', function () {
        $.ajax({
            type: 'post',
            url:  '/core/login_ajax',
            data: $('#loginForm').serialize(),
            success: function(data){
                response = $.parseJSON(data);
                $('#responseLogin').html(response.message);
                $('#responseLogin').addClass(response.type + ' alert');

                if(response.type == 'success'){
                    setTimeout(function(){
                        window.location = '/core/';
                    }, 2500);
                }
            },
            error: function(data){
                alert('A intervenit o eroare la trimiterea datelor. Va rugam reincarcati pagina');
            }
        });
        return false;
    });

    $('#reserveForm').bind('submit', function(){
        return false;
    });

    $("input[name=cazare]").change(function() {
        checkCazare();
    });

});

function makeRezervare(){
    $.ajax({
        type: 'GET',
        url:  '/core/reserve_ajax',
        data: $('#reserveForm').serialize(),
        success: function(data){
            console.log(data);

            changeStep(6);
        },
        error: function(data){
            alert('A intervenit o eroare la trimiterea datelor. Va rugam reincarcati pagina');
        }
    });
};


function checkStepTwo(){
    if($('#date_end').val() >= $('#date_start').val()){
        checkCazare();
        changeStep(2);
        $('#dataError').css('display','none');
    }else{
        $('#dataError').css('display','block');
    }
};

function checkStepThree(){
    $.ajax({
        type: 'GET',
        url:  '/core/check_spots_ajax',
        data: {
            'date_e' : $('#date_end').val(),
            'data_s' : $('#date_start').val(),
            'cazare' : $('input[name=cazare]:checked').val(),
            'tip_casa' : $('#tip_c').val()
        },
        success: function(data){
            response = $.parseJSON(data);
            console.log(response);
            var tbl = '<ul class="spotsList">';

            $.each(response,function(i,val){
                tbl = tbl + '<li id="' + val.id_loc + '"> Locul '
                    + val.id_loc
                    + '<div class="btn btn-info" onclick="getSpotDetails('+ val.id_loc +')">Verifica locul</div>'
                    + '<div id="spotDetails' + val.id_loc + '"></div>'
                    + '</li>';
            });
            tbl = tbl + '</ul>'
            $('#tableReserve').html(tbl);
        },
        error: function(data){
            alert('A intervenit o eroare la trimiterea datelor. Va rugam reincarcati pagina');
        }
    });

    changeStep(3);
};

function checkStepFive(){
    calculate_cost(
        $('#date_start').val(),                    //start date
        $('#date_end').val(),                      //end date
        $('input[name=tip_pachet]:checked').val(),  //pachet
        $('input[name=cazare]:checked').val(),     //cazare
        $('#tip_c').val()                          //tip casa
    );
    changeStep(5);
};

function  changeStep(step) {
    $('.step').each(function(index,item){
        $(this).css('display','none');
    });
    $('#step' + step).css('display','block');
};

function  rezerva(id_loc,partial) {
    if(partial!=null){
        changeStep(7);
        completePartial();
    }else{
        changeStep(4);
    }
    $('#location').val(id_loc);
};

function checkCazare(){
    if($('input[name=cazare]:checked').val() == 1){
        $('#tip_casa').css('display','block');
    }else{
        $('#tip_casa').css('display','none');
    }
};


function getSpotDetails(id_loc){
    $.ajax({
        type: 'GET',
        url:  '/core/check_spot_ajax',
        data: {
            'date_e' : $('#date_end').val(),
            'date_s' : $('#date_start').val(),
            'id_loc' : id_loc
        },
        success: function(data){
            response = $.parseJSON(data);
            var spot='<div class="spot-details">';
            var cls='disponibil';
            check=true;
            var oneDay=false;

            if( $('#date_end').val() == $('#date_start').val()){
                oneDay == true;
            }

            $.each(response,function(key,value){
                if(value == 0){
                    cls = 'disponibil';
                }else{
                    check = false;
                    cls = 'indisponibil';
                }

                if( (oneDay == true) && ($('input[name=cazare]:checked').val() ==0) ){
                    switch (value){
                        case 0:
                            spot = spot + '<p class="' + cls + '">' + key + ' : <strong>' + listaDisponibil[value] + '</strong></p>';
                            check = true;
                            programValid=[0,1,2];
                            break;
                        case 1:
                            spot = spot + '<p class="' + cls + '">' + key + ' : <strong>' + listaDisponibil[value] + '</strong></p>';
                            check = true;
                            programValid=[2];
                            break;
                        case 2:
                            spot = spot + '<p class="' + cls + '">' + key + ' : <strong>' + listaDisponibil[value] + '</strong></p>';
                            check = true;
                            programValid=[1];
                            break;
                        case 3:
                            spot = spot + '<p class="' + cls + '">' + key + ' : <strong>' + listaDisponibil[value] + '</strong></p>';
                            break;
                    }
                }else{
                    spot = spot + '<p class="' + cls + '">' + key + ' : <strong>' + listaDisponibil[value] + '</strong></p>';
                }

            });

            if(check == true){
                spot = spot + '<div class="btn-rezerva btn btn-primary" onclick="rezerva('+ id_loc +')">Rezerva </div>';
            }
            spot = spot + '</div>';

            $('#spotDetails' + id_loc).html(spot);
        },
        error: function(data){
            alert('A intervenit o eroare la trimiterea datelor. Va rugam reincarcati pagina');
        }
    });
};

function calculate_cost(start,end,pachet,cazare,tip_casa){
    start_date = new Date(start);
    end_date = new Date(end);
    var cost_pachet = 0;
    var cost_total = 0;
    var cost_cazare = 0;
    if(cazare != null){
        for (var d = new Date(start); d <= end_date; d.setDate(d.getDate() + 1)) {
            if(d.getDay() ==5  || d.getDay() == 6){
                cost_cazare = cost_cazare + listaCasa[tip_casa] + 40;
            }else{
                cost_cazare = cost_cazare + listaCasa[tip_casa];
            }
            cost_pachet = cost_pachet +listaPachet[pachet][0];
        }
    }
    cost_total = cost_pachet + cost_cazare;
    $('#perioada_final').html(start + ' - ' + end);
    $('#pachet_final').html(listaPachet[pachet][1]);
    $('#cost_final').html(cost_total + 'RON');
    $('#preluare_cost_final').val(cost_total);
}

$('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15 // Creates a dropdown of 15 years to control year
});
$(document).ready(function(){
    $('.collapsible').collapsible();
});
