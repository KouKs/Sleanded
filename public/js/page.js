
/* 
 * Animated page loading
 */
$(document).ready( function() {
    
    /* loading with scrolling */
    $(".area").showContent( );
    $(".progress-bar").showBar( );
    $(this).scroll( function() {
        $(".area").showContent( );
        $(".progress-bar").showBar( );
    });    
    
    /* smooth scrolling */
    $("html").niceScroll({scrollspeed: 65});
    $("#port").niceScroll("#bar",{scrollspeed: 65});
    
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
/*
 * Leave page function
 */
$.fn.leavePage = function() {   

    this.click(function(event){

        event.preventDefault();
        linkLocation = this.href === undefined ? this.form.action : this.href;
        $("body .page").fadeOut( "slow" , function() {
            location.href = linkLocation;
        });
    }); 
};