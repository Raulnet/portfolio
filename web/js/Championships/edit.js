/**
 * Created by laurentnegre on 02/09/15.
 */




$(function () {

    findGridsPoints($('#championship_grid_points_id').val(), $('#championship_grid_points_id').attr('data-url'));


    $('#championship_grid_points_id').unbind('change');
    $('#championship_grid_points_id').bind('change', function(){

    findGridsPoints($(this).val(), $(this).attr('data-url'));

    });

    function findGridsPoints(id, url){
        $.ajax({
            type: "POST",
            url: url,
            data: {gridId: id },
            success: function (response) {
                removeGridPoints();
                appendGridPoints(response);
            }
        })
    }

    function removeGridPoints(){
        $('.panel').remove();
    }

    function appendGridPoints(response){
        $('#grid_panel').append('<div  class="panel"><div class="panel-heading">Grids - Points</div><table class="table table-condensed" id="gridPoints"><tr><th>Results</th><th>Points</th></tr></table></div>');

        $.each(response, function(key, value){
            $('#gridPoints').append("<tr><td>"+key+"</td><td>"+value+"</td></tr>");
        })

    }


















});