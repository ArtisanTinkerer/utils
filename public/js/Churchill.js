/**
 * Convert text to number.
 *
 * @param val
 * @returns {Number}
 */

function getNum(val) {
    if (isNaN(val)) {
        val= 0;
    }

    if (val=="") {
        val =  0;
    }

    return parseInt(val);
}


//this is the function to move to the next field if Enter has been pressed
function gotoNextField(nextId,e){
    if(e.keyCode == 13)
    {
        $(nextId).focus();
        e.preventDefault();
    }

}

//This selects text when clicked
$(document).ready(function () {
    $("input").focus(function () {
        $(this).select();
    });

    /*$(function(){
        $(document).on('click','input[type=text]',function(){ this.select(); });
    });*/

});