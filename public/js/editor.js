/* 
 * Editor script
 * 
 * vypadá to strašně, musím to přerobit...
 * 
 * @author Kouks
 */

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
            '<div class="editor-preview">\n\
                <section class="part">\n\
                    <div class="area">\n\
                        <div spellcheck="false" contenteditable="true" class="text-area"></div>\n\
                    </div>\n\
                </section>\n\
            </div>'        
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
    $("ul.editor-menu").menuItem("red",         "red" , "bg");
    $("ul.editor-menu").menuItem("light-grey",  "grey" , "bg");
    $("ul.editor-menu").menuItem("grey",        "dark-grey" , "bg");
    $("ul.editor-menu").menuItem("white",       "white" , "bg");
    $("ul.editor-menu").menuItem("static");
    $("ul.editor-menu").menuItem("image",       "" , "img");
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
        sel = selection( );
        
        /*
         * removing whitespaces
         */
        if(sel && $(".editor-preview").has(sel.parent).length !== 0 )
            $(sel.parent).html($(sel.parent).html().replace("&nbsp;"," ")); 
        
        switch( action ) {
            case 'section':
                
                /*
                 * new section
                 */
                $(editor).html( $(editor).html() + html);
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
                    if( $(el).is("body") ) break;
                }
                if( !$(el).is("body") ) $(el).removeAttr('class').addClass('part ' + html);
                break;
                
            default:
                
                /*
                 * default wrapping
                 */
                if(!sel || sel.start === sel.end || $(".editor-preview").has(sel.parent).length === 0 ) break;
                $(sel.parent).html('');
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
            parent : sel.focusNode.parentElement
        };
    } else {
        return false;
    }
};

$(document).bind('keydown', function(e) {
    if( e.which === 8 || e.which === 46 ) {
        sel = selection( );
        if( sel && $(sel.parent).hasClass("area") && sel.parent.innerText === '' ) {
            e.preventDefault();
            $(sel.parent).parent().remove();
        }
    }
    
});

$(document).submit(function(e) { 
    $(".editor-preview > section > div > div").each( function( ) {
        $(this).attr("contenteditable","false");
    });
    $(".editor").val($(".editor-preview").html());
    $(".editor-preview > section > div > div").each( function( ) {
        $(this).attr("contenteditable","true");
    });
});