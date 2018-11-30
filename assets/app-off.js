$(function () {
    $('#checkin').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 3 ,// Creates a dropdown of 15 years to control year
        min: Date.now(),
        disable: [
            {from: [2017,9,4], to: [2017,9,8]},
            {from: [2017,8,22], to: [2017,8,24]}
            
        ],
        close: 'Select',
        closeOnSelect: true,
        onSet: function( arg ) {
            if ( 'select' in arg ){ //prevent closing on selecting month/year
                this.close();
            }
        },
        onClose: function( selectedDate ) {
//            $('#checkout').pickadate({min : $('#checkin').val()});
            $('#checkout').pickadate('picker').set('min',$('#checkin').val());
        }
    });

    $('#checkout').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 3, // Creates a dropdown of 15 years to control year
        min: Date.now(),
        disable: [
            {from: [2017,9,4], to: [2017,9,8]},
            {from: [2017,8,22], to: [2017,8,24]}
            
        ],
        close: 'Select',
        onSet: function( arg ) {
            if ( 'select' in arg ){ //prevent closing on selecting month/year
                this.close();
            }
        },
        onClose: function( selectedDate ) {
            $('#checkin').pickadate('picker').set('max',$('#checkout').val());
        }
    });

    $(document).ready(function(){
        // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
        $('.modal').modal();
    });
});