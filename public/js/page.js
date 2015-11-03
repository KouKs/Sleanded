
/* 
 * Animated page loading
 */
$(document).ready( function() {
    
    /* side menu */
    $("#side a").each( function( ) {
        $(this).css({color:"transparent",fontSize: "0px"});
    });
    $("#side").hover( function() {
        $("#side a").each( function( ) {
            $(this).css({color:"#aaa",fontSize: "14px"});
        });
    },function( ){
        $("#side a").each( function( ) {
            $(this).css({color:"transparent",fontSize: "0px"});
        });
    });
    
    /* loading */
    $("#top-bar").fadeIn("slow",function() {
        $("#motto").fadeIn("slow",function() {
            $("#buttons")./*fadeIn().*/animate({top:"40%",opacity:1},"slow");
        });
    });
    
    /* topbar animation */
    $(this).scroll( function() {
        if( $(window).scrollTop() > 0 ) {
            if( $("#fixed-bar").css("display") === "none" ) {
                $("#fixed-bar").fadeIn();
                $("#fixed-bar").append($("#top-bar"));
            }
        } else {
            if( $("#top-bar").css("display") !== "none" ) {
                    $("header").append($("#top-bar"));
                $("#fixed-bar").stop(true,false).fadeOut( );
            }
        }
        
    });
    
    /* binding function to elements */
    $('.leave').leavePage();
});
