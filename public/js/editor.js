/* 
 * Editor script
 * 
 * vypadá to strašně, musím to přerobit...
 * 
 * @author Kouks
 */

$.fn.editor = function( ) {
    
    var el          = $(this);
    var container   = $(this).parent();
    var preview     = container.preview();
    
    container.menu();
};

$.fn.preview = function( ) {
    $(this).prepend(
        '<div class="preview"></div>'        
    );
    return $("div.preview");
};

$.fn.menu = function( ) {
    
    $(this).prepend( 
        '<ul class="editor-menu"></ul>'
    );    
    
    $("ul.editor-menu").menuItem("text","action");
};

$.fn.menuItem = function( label , action ) {
    li = document.createElement('li');
    $(li).html( label );
    $(li).click( function( ) {
        alert(action);
    });
    $(this).append(li);
};
