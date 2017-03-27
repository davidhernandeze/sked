dateCont = 0;
$('#date-picker').datepick({
    showOnFocus: false,
    onSelect: function (dates) {
        dateCont++;
        if (dateCont == 1) {
            $('#dates-input').append('<div id="dates-header" class="row visible-md visible-lg">' +
                '<div class="col-sm-12" style="height: 20px"></div>' +
                '<div class="col-sm-2"></div>' + '<div class="col-sm-4">' +
                '<p class="text header-text">Days</p>' + '</div>' +
                '<div class="col-sm-2">' +
                '<p class="text header-text">Time</p>' + '</div>' + '</div>');
        }
        var date = new Date(dates);
        var options = {month: "long", day: "numeric", year: "numeric"};
        var dateToShow = date.toLocaleTimeString("en-us", options);
        dateToShow = dateToShow.split(' ').slice(0, 3).join(' ');
        dateToShow = dateToShow.replace(/,/g, '');
        var sqlDate = date.toISOString();
        var sqlDate = sqlDate.replace("T", " ");
        var sqlDate = sqlDate.substring(0, sqlDate.length - 14);
        var newInput = '<div class="form-group row">' +
            '<div class="col-xs-4 col-sm-4 col-sm-offset-2">' +
            '<p class="text" style="text-align: center">' +
            dateToShow + '</p>' + '<input name="dates[' + dateCont + '][date]" type="hidden" ' + 'value="' +
            sqlDate + '">' +
            '</div>' +
            '<div class="col-xs-4">' +
            '<input type="text" name="dates[' + dateCont + '][time]" class="timepicker form-control input"/>'+
            '</div>' +
            '<div class="col-xs-2">' +
            '<button type="button" class="btn btn-danger button-remove-date">x</button>'+
            '</div>' +
            '</div>' +
            '</div>';
        $('#dates-input').append(newInput);

        $('.timepicker').wickedpicker({
            title: ""
        });
        $('#timepicker' + dateCont).timepicki();

        // var formatedDate = $.datepicker.formatDate('dd-mm-yy', date);
        // var formatedToday = $.datepicker.formatDate('dd-mm-yy', today);

    }
});

$('body').on('click', '.button-remove-date', function (){

    $(this).parent().parent().remove();
    dateCont--;

    if(dateCont == 0){

        $('#dates-header').remove();
    }

});