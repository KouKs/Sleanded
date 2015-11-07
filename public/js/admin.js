
var _URL = "/sleanded/public/admin/";

/* 
 * Page loading
 */
$(document).ready( function() {
    /*
     * Menu
     */
    $("#primary > a").hover( function( ) {
        $(this).next().css({top: $(this).offset().top});
    });
    $("#primary > nav").hover( function( ) {
        $(this).prev().css({ 'background': "#333" , 'border-color': "#333"});
    }, function() {
        $(this).prev().css({ 'background': "" , 'border-color': ""});
    });
});

