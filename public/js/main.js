/* 
 * Variables
 */

var _URL = "/sleanded/public/";

/* 
 * Page loading
 */
$(document).ready( function() {
    /* smooth scrolling */
    $("html").niceScroll({scrollspeed: 65});
    $("#port").niceScroll("#bar",{scrollspeed: 65});
    
    /* loading with scrolling */
    $(".area").showContent( );
    $(this).scroll( function() {
        $(".area").showContent( );
        $(".progress-bar").showBar( );
    });    
    
    window.setTimeout( function( ){
        $(".message").fadeOut();
    } , 4000 );
    
    $(window).load(function() {
        $('.grid').masonry({
            itemSelector: '.grid-item'
        });
    });
});

/*
 * Functions
 */
$.fn.showContent = function( ) {   
    this.each( function( ) {
        if( $(this).css("opacity") < 1 && $(window).scrollTop() > $(this).offset().top - 650 ) {
            $(this).animate({opacity: 1});
            return;
        }
    });
};

$.fn.showBar = function( ) {  
    this.each( function( ) {
        if( $(this).children().first().css("width") !== 0 && $(window).scrollTop() > $(this).offset().top - 650 ) {
            $(this).children().first().animate({width: $(this).data("percent")},1500);
            return;
        }
    });    
};

/* 
 * Ajax function
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