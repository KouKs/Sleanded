/* 
 * Page loading
 */

var _URL = "/sleanded/public/admin/";

/* 
 * Animated page loading
 */
$(document).ready( function() {
    /* smooth scrolling */
    $("html").niceScroll({scrollspeed: 65});
    $("#port").niceScroll("#bar",{scrollspeed: 65});
    
    /* loading with scrolling */
    $(".area").showContent( );
    $(this).scroll( function() {
        $(".area").showContent( );
    });   
});

/*
 * Function to show area of content
 */
$.fn.showContent = function( ) {   
    this.each( function( ) {
        if( $(this).css("opacity") < 1 && $(window).scrollTop() > $(this).offset().top - 650 ) {
            $(this).animate({opacity: 1});
            return;
        }
    });
};