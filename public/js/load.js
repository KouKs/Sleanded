/* 
 * Page loading
 */

var _URL = "/sleanded/public/";

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
    
    /* smooth scrolling */
    $("html").niceScroll({scrollspeed: 65});
    $("#port").niceScroll("#bar",{scrollspeed: 65});
    
    /* binding function to elements */
    $('.leave').leavePage();
    
    /* loading with scrolling */
    $(".area").showContent( );
    $(this).scroll( function() {
        $(".area").showContent( );
        $(".progress-bar").showBar( );
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

$.fn.showBar = function( ) {  
    this.each( function( ) {
        if( $(this).children().first().css("width") !== 0 && $(window).scrollTop() > $(this).offset().top - 650 ) {
            $(this).children().first().animate({width: $(this).data("percent")},1500);
            return;
        }
    });    
}

/* 
 * Function to animate leaving a page
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