/* 
 * Editor script
 * 
 * vypadá to strašně, musím to přerobit...
 * 
 * @author Kouks
 */

$.fn.editor = function( ) {
    $(this).hide();
    
    var container   = $(this).parent();
    container.preview( $(this).val() );
    container.menu();
};

$.fn.preview = function( content ) {
    if( content === undefined ) {
        $(this).prepend(
            '<div class="editor-preview">\n\
                <section class="part">\n\
                    <div class="area">\n\
                        <div contenteditable="true" class="text-area"></div>\n\
                    </div>\n\
                </section>\n\
            </div>'        
        );
    } else {
        $(this).prepend(
            '<div class="editor-preview"></div>'        
        );
        $(".editor-preview").html( content );
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
    $("ul.editor-menu").menuItem("red",         "<p class='red-text'>{text}</p>");
    $("ul.editor-menu").menuItem("grey",        "<p class='grey-text'>{text}</p>");
    $("ul.editor-menu").menuItem("light-grey",  "<p class='light-grey-text'>{text}</p>");
    $("ul.editor-menu").menuItem("white",       "<p class='white-text'>{text}</p>");
    $("ul.editor-menu").menuItem("remove formatting",'',"remove");
    $("ul.editor-menu").menuItem("+",'<section class="part"><div class="area"><div contenteditable="true" class="text-area"></div></div></section>','section');
};

$.fn.menuItem = function( label , html , action ) { 
    var editor = $(".editor-preview");
    /**
     * creating new li element
     */
    li = document.createElement('li');
    
    /**
     * label (in menu)
     */
    $(li).html( label );
    
    /**
     * preventing deslection
     * @param e event
     */
    $(li).mousedown( function(e) {
        e.preventDefault();
    });
    
    /**
     * click event
     */
    $(li).click( function() { 
        sel = selection( );
        console.log(sel);
        switch( action ) {
            case 'section':
                $(editor).html( $(editor).html() + html);
                break;
            case 'remove':
                if(!sel) break;
                el = sel.parent;
                while( !$(el).is("div") || !$(el).hasClass("area") ) {
                    html = $(el).html();
                    el = $(el).parent();
                    $(el).html( html );
                }
                break;
            default:
                if(!sel || sel.start === sel.end ) break;
                $(sel.parent).html( 
                    $(sel.parent).html().substr( 0 , sel.start ) + 
                    html.replace("{text}", sel.text) +
                    $(sel.parent).html().substr( sel.end , $(sel.parent).html().length )
                );
        }

    });
    
    /**
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
            parent : sel.focusNode.parentElement
        };
    } else {
        return false;
    }
};

$(document).bind('keyup', function() {
    $(".editor-preview > section > div > div").each( function( ) {
        $(this).attr("contenteditable","false");
    });
    $(".editor").val($(".editor-preview").html());
    $(".editor-preview > section > div > div").each( function( ) {
        $(this).attr("contenteditable","true");
    });
});