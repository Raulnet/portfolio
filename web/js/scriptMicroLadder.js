/* ===== Function MicroLadder ===== */

function tagPlayer(id) {

    if(  $('.' + id).is(".playerSelected") ){

        $('.' + id).removeClass("playerSelected");
    }
    else if ($('tr').is(".playerSelected")){

        $('tr').removeClass("playerSelected");
        $('.' + id).addClass("playerSelected");
    }
    else {
        $('.' + id).addClass("playerSelected");
    }


}