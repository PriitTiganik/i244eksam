/**
 * Created by Priit on 12/06/2016.
 */


$(document).ready(function(){

    $("td").css({
        "color":"red",
        "font-weight":"bold"
    });


    $('td').on({ ///mitu tegevust koos: .on
        mouseenter: function(){//midateha
            $(this).css("background-color","white");
        },
        mouseleave: function(){
            $(this).css("background-color","skyblue");
        },
        click: function(){
            $(this).css("color","Gold");
        }
    });
});