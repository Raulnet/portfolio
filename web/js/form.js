/**
 * Created by laurentnegre on 12/09/15.
 */
$(function () {

    $('input[id$="timer_hours"]').unbind('change');
    $('input[id$="timer_hours"]').bind('change',function(){

        $(this).val(pad($(this).val(), 2));
    });

    $('input[id$="timer_minutes"]').unbind('change');
    $('input[id$="timer_minutes"]').bind('change',function(){

        $(this).val(pad($(this).val(), 2));
    });

    $('input[id$="timer_seconds"]').unbind('change');
    $('input[id$="timer_seconds"]').bind('change',function(){

        $(this).val(pad($(this).val(), 2));
    });

    $('input[id$="timer_milliseconds"]').unbind('change');
    $('input[id$="timer_milliseconds"]').bind('change',function(){

        $(this).val(pad($(this).val(), 3));
    });

    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }
});