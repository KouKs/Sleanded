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
    
    /*menu - nechtěl jsemt to řeši přes js, ale css je ještě hoší než jquery kappa*/
    $("header > nav > div > nav").hover(function(){
        $(this).prev().css({"background": "#333","border-color": "#333"});
    },function(){
        $(this).prev().css({"background": "#b23432","border-bottom-color": "#982D2B","border-top-color": "#E34240"});
        
    });
    
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