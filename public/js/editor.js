/* 
 * Editor script
 * 
 * vypadá to strašně, musím to přerobit...
 * 
 * @author Kouks
 */

var Memory = new Array();

$.fn.editor = function( ) {
    /**
     * hiding actual textare
     */
    $(this).hide();
    
    /**
     * 
     * @type jQuerypreparing preview container and menu
     */
    var container   = $(this).parent();
    container.preview( $(this).val() );
    container.menu();
};

$.fn.preview = function( content ) {
    if( content === '' ) {
        $(this).prepend(
            '<div class="editor-preview">'+
                '<section class="part">'+
                    '<div class="area">'+
                        '<div spellcheck="false" contenteditable="true" class="text-area"></div>'+
                    '</div>'+
                '</section>'+
            '</div>'        
        );
    } else {
        $(this).prepend(
            '<div class="editor-preview"></div>'        
        );
        $(".editor-preview").html( content );
        $(".editor-preview div.text-area").each( function( ) {
            $(this).attr("contentEditable","true");
        });
    }
};

$.fn.menu = function( textarea ) {
    
    $(this).prepend( 
        '<ul class="editor-menu"></ul>'
    );    
    
    $("ul.editor-menu").menuItem("H1",          "<h1 class='red-text center'>{text}</h1>");
    $("ul.editor-menu").menuItem("H2",          "<h2>{text}</h2>");
    $("ul.editor-menu").menuItem("H3",          "<h3>{text}</h3>");
    $("ul.editor-menu").menuItem("H4",          "<h4>{text}</h4>");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("black",       "<span class='black-text'>{text}</span>");
    $("ul.editor-menu").menuItem("red",         "<span class='red-text'>{text}</span>");
    $("ul.editor-menu").menuItem("grey",        "<span class='grey-text'>{text}</span>");
    $("ul.editor-menu").menuItem("light-grey",  "<span class='light-grey-text'>{text}</span>");
    $("ul.editor-menu").menuItem("white",       "<span class='white-text'>{text}</span>");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("bold",        "<span class='bold'>{text}</span>");
    $("ul.editor-menu").menuItem("underline",   "<span class='underline'>{text}</span>");
    $("ul.editor-menu").menuItem("italic",      "<span class='italic'>{text}</span>");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("big",          "<span class='big'>{text}</span>");
    $("ul.editor-menu").menuItem("medium",      "<span class='medium'>{text}</span>");
    $("ul.editor-menu").menuItem("small",       "<span class='small'>{text}</span>");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("justify",     "<p class='justify'>{text}</p>");
    $("ul.editor-menu").menuItem("center",      "<p class='center'>{text}</p>");
    $("ul.editor-menu").menuItem("left",        "<p class='left'>{text}</p>");
    $("ul.editor-menu").menuItem("indent",      "<p class='indent'>{text}</p>");
    $("ul.editor-menu").menuItem("margin",      "<p class='margin'>{text}</p>");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("remove formatting",'',"remove");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("+",           '<section class="part"><div class="area"><div contenteditable="true" class="text-area"></div></div></section>','section');
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("one",         "area" , "parts");
    $("ul.editor-menu").menuItem("two",         "half" , "parts");
    $("ul.editor-menu").menuItem("three",       "third" , "parts");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("red",         "red" , "bg");
    $("ul.editor-menu").menuItem("light-grey",  "grey" , "bg");
    $("ul.editor-menu").menuItem("grey",        "dark-grey" , "bg");
    $("ul.editor-menu").menuItem("white",       "white" , "bg");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("image",       "" , "img");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("undo",        "" , "undo");
};

$.fn.menuItem = function( label , html , action ) { 
    var editor = $(".editor-preview");
    /*
     * creating new li element
     */
    li = document.createElement('li');
    
    /*
     * label (in menu)
     */
    if( label === 'static' ) {
        $(li).addClass( label );
        $(this).append(li);
        return;        
    } else {
        $(li).html( label );
    }
    /*
     * preventing deslection
     * @param e event
     */
    $(li).mousedown( function(e) {
        e.preventDefault();
    });
    
    /**
     * click event
     */
    $(li).mouseup( function() {
        
        /*
         * getting selected area
         */
        var sel = selection( );
        
        switch( action ) {
            case 'section':
                
                /*
                 * new section
                 */
                $(editor).html( $(editor).html() + html);
                break;
                
            case 'parts':
                
                if(!sel || $(".editor-preview").has(sel.parent).length === 0 ) break;
                
                count = {
                    area : 1,
                    half : 2,
                    third: 3
                };
                
                el = sel.parent;
                while( !$(el).is('section') ) {
                    el = $(el).parent();
                    if( $(el).is("body") ) return;
                }
                $(el).children().each( function( ) {
                    $(this).remove();
                });
                
                for( i = 0 ; i < count[html] ; i++ ) {
                    $(el).append( 
                        '<div class="' + html + '"><div contenteditable="true" class="text-area"></div></div>'
                    );
                }
                break;
                
            case 'remove':
                
                /*
                 * removing formatting
                 */
                if(!sel || $(".editor-preview").has(sel.parent).length === 0 ) break;
                el = sel.parent;
                while( !$(el).is("div") || !$(el).hasClass("text-area") ) {
                    html = $(el).html();
                    el = $(el).parent();
                    $(el).html( html );
                }
                break;
                
            case 'bg':
                
                /*
                 * changing bg
                 */
                if(!sel || $(".editor-preview").has(sel.parent).length === 0 ) break;
                el = sel.parent;
                while( !$(el).is("section") || !$(el).parent().hasClass("editor-preview") ) {
                    el = $(el).parent();
                    if( $(el).is("body") ) return;
                }
                $(el).removeAttr('class').addClass('part ' + html);
                break;
                
            case 'img':
                
                /*
                 * adding img
                 */
                if(!sel || $(".editor-preview").has(sel.parent).length === 0 ) break;
                $(".media-window-tab").fadeIn();
                $(".media-window-tab .grid").masonry().masonry("reloadItems");
                break;
                
            case 'undo':
                
                /*
                 * adding img
                 */
                if( Memory.length > 0 ) $(".editor-preview").html( Memory[ Memory.length - 1 ] );
                Memory.pop();

                break;
                
            default:
                
                /*
                 * default wrapping
                 */
                if(!sel || sel.start === sel.end || $(".editor-preview").has(sel.parent).length === 0 ) break;
                
                /*
                 * removing whitespaces
                 */
                $(sel.parent).html($(sel.parent).html().replace("&nbsp;"," ")); 
                
                $(sel.parent).html( 
                    $(sel.parent).html().substr( 0 , sel.start ) + 
                    html.replace("{text}", sel.text) +
                    $(sel.parent).html().substr( sel.end , $(sel.parent).html().length )
                );
        }
    });
    
    /*
     * adding to menu
     */
    $(this).append(li);
};

function selection( ) {
    sel = window.getSelection();
    if( sel !== undefined ) {
        start = sel.baseOffset < sel.extentOffset ? sel.baseOffset : sel.extentOffset;
        end   = sel.baseOffset > sel.extentOffset ? sel.baseOffset : sel.extentOffset;
        return {
            start  : start,
            end    : end,
            text   : sel.toString(),
            parent : $(sel.focusNode.parentElement),
            wrap   : $(sel.focusNode)
        };
    } else {
        return false;
    }
};

/**
 * removing section
 * @param e event
 */
$(document).bind('keydown', function(e) {
    if( e.which === 8 || e.which === 46 ) {
        sel = selection( );
        if( sel && $(sel.parent).parent().hasClass("part") && $(sel.parent).parent().text() === '' ) {
            e.preventDefault();
            $(sel.parent).parent().remove();
        }
    }
});

/**
 * memory
 * @param e event
 */
$(document).bind('keyup', function(e) {
    if( $(".editor-preview").has( e.target) !== 0 ) {
        Memory.push( $(".editor-preview").html() );
    }
});/*
$(document).bind('click', function(e) {
    if( $(".editor-menu").has( e.target ) !== 0 ) {
        Memory.push( $(".editor-preview").html() );
    }
});*/

/**
 * copying content to textarea on submit
 * @param e event
 */
$(document).submit(function(e) { 
    $(".editor-preview > section > div > div").each( function( ) {
        $(this).attr("contenteditable","false");
    });
    $(".editor").val($(".editor-preview").html());
    $(".editor-preview > section > div > div").each( function( ) {
        $(this).attr("contenteditable","true");
    });
});

/**
 * choosing image
 * @param e event
 */
$(document).bind('click', function(e) {
   if( $(e.target).is(".media-window-tab img") ) {
       
       sel = selection();
       if(!sel || $(".editor-preview").has(sel.parent).length === 0 ) return;
       
       /*
        * removing whitespaces
        */ 
       $(sel.wrap).html($(sel.wrap).html().replace("&nbsp;"," "));   

       /*
        * adding img
        */ 
       $(sel.wrap).html( 
           $(sel.wrap).html().substr( 0 , sel.start ) + 
           '<img class="shadowed" src="' + $(e.target).attr("src") + '" />' + 
           $(sel.wrap).html().substr( sel.end , $(sel.wrap).html().length )
       );
       $(".media-window-tab").fadeOut();
   }
});