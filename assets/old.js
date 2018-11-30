/**
 * Created by Elena Roman on 28/12/2016.
 */
var step=1;
$(function () {

    $('#registerForm').bind('submit', function () {
        $.ajax({
            type: 'post',
            url: '/balta/core/register_ajax',
            data: $('#registerForm').serialize(),
            success: function(data){
                response = $.parseJSON(data);
                $('#responseRegister').html(response.message);
                $('#responseRegister').addClass(response.type + ' alert');
                if(response.type == 'success'){
                    setTimeout(function(){
                        window.location = '/balta/core/login';
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
            url:  '/balta/core/login_ajax',
            data: $('#loginForm').serialize(),
            success: function(data){
                response = $.parseJSON(data);
                $('#responseLogin').html(response.message);
                $('#responseLogin').addClass(response.type + ' alert');

                if(response.type == 'success'){
                    setTimeout(function(){
                        window.location = '/balta/core/';
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

});

function checkStepTwo(){
    if($('#date_end').val() >= $('#date_start').val()){
        changeStep(2);
        $('#dataError').css('display','none');
    }else{
        $('#dataError').css('display','block');
    }
};


function checkStepThree(){
    $.ajax({
        type: 'GET',
        url:  '/balta/core/check_spots_ajax',
        data: {
            'date_e' : $('#date_end').val(),
            'data_s' : $('#date_start').val(),
            'cazare' : $('input[name=cazare]:checked').val()
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

function  changeStep(step) {
    $('.step').each(function(index,item){
        $(this).css('display','none');
    });
    $('#step' + step).css('display','block');
}

function getSpotDetails(id_loc){
    $.ajax({
        type: 'GET',
        url:  '/balta/core/check_spot_ajax',
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
            $.each(response,function(key,value){
                if(value!='Disponibil'){
                    check = false;
                    cls = 'indisponibil';
                }else{
                    cls = 'disponibil';
                }

                spot = spot + '<p class="' + cls + '">' + key + ' : <strong>' + value + '</strong></p>';

            });
            if(check == true){
                spot =spot + '<div class="login-register">';
                spot =spot + '<p> Va rugam sa va logati sau sa va creati un cont inainte de a face o rezervare</p>';
                spot = spot + '<a href="' + '/balta/core/login' + '" class="' + 'btn btn-primary twoBtn' + '" > Login </a>'
                    + '<a href="' + '/balta/core/register' + '" class="' + 'btn btn-info twoBtn' + '"> Register </a>';
                //       spot = spot + '<div class="btn-rezerva btn btn-primary" onclick="rezerva('+ id_loc +')">Rezerva </div>';
                spot = spot + '</div>';
            }
            spot = spot + '</div>';
            $('#spotDetails' + id_loc).html(spot);
        },
        error: function(data){
            alert('A intervenit o eroare la trimiterea datelor. Va rugam reincarcati pagina');
        }
    });


};