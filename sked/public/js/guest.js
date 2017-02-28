$(document).ready(function(){

    $('#datesTable button.move').click(function() {

        var row = $(this).closest('tr');

        if ($(this).hasClass('up'))
            row.prev().before(row);
        else
            row.next().after(row);
    });

    $('#datesTable button.remove').click(function() {

        var row = $(this).closest('tr');


        row.removeClass('visible');
        row.addClass('hidden');

        var rowNumber = $('#datesTable tr.visible').length;

        if(rowNumber == 0){

            $('.table-head').remove();

        }

    });

    $('#button-sked').click(function(){

        var orderedDates = [];
        var disabledDates = [];

        $('#datesTable > tbody > tr').each(function () {

            var date_id = $(this).find('.id-field').text();

            if(!$(this).hasClass('hidden')){

                orderedDates.push(date_id);

            }
            else{

                disabledDates.push(date_id);

            }

        });
        var eventId = $('#eventId').val();
        var guestId = $('#guestId').val();

        var data = {'dates': orderedDates, 'disabledDates': disabledDates, 'eventId': eventId, 'guestId' : guestId};


        $.ajax({
            type: "POST",
            url: '/guest/store',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                $.loadingBlockHide
                window.location.href = '/success';
            },
        });
        $.loadingBlockShow({
            text: '',
            imgPath: 'img/default.svg',
            imgStyle: {
                width: 'auto',
                textAlign: 'center',
                marginTop: '20%'
            },
        });

    });

});


