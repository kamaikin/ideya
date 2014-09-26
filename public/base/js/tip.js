(function($){
    tooltip = function() {

        this._init = function(element, options) {

            var defaults = {
                el: $(element),
                elMessageClass: "messageTip",
                elMessageBl: 'div',
                fullWidthClass: 'full-width',
                side: "right",
                hover: false,
                fix: false,
                elMessageFixIndent: 10,
                tipHelp: 'tip-help'
            },
            settings = $.extend(defaults, options);

            settings.el.each(function(){

                var $el = $(this),
                    $elHeight = $el.actual( "outerHeight", { absolute : true } ),
                    $elWidth = $el.actual( "outerWidth", { absolute : true } ),
                    $elData = $el.data("tip_message"),
                    $elNum = $el.data("tip_class"),
                    $elMessage = $("<" + settings.elMessageBl + " class='" + settings.elMessageClass + ' '+ settings.elMessageClass + '-' + $elNum+ "'>" + $elData + "</" + settings.elMessageBl + ">");

                $el
                    .wrap('<div class="'+settings.elMessageClass+'-wrapper"></div>')
                    .parent().append($elMessage);

                var $elMessageHeight = $elMessage.actual( "outerHeight"),
                    $elMessageWidth = $elMessage.actual( "outerWidth"),
                    $elMessageTop = (($elHeight/2) - ($elMessageHeight/2)),
                    $elMessageLeft = (($elWidth/2) - ($elMessageWidth/2));

                if (!settings.fix) {
                    if (settings.side == "right") {
                        $elMessage
                                .addClass(settings.elMessageClass+"-right")
                                .css("top", $elMessageTop);
                    }
                    else if (settings.side == "left"){
                        $elMessage
                                .addClass(settings.elMessageClass+"-left")
                                .css("top", $elMessageTop);
                    }
                    else if (settings.side == "top"){
                        $elMessage
                                .addClass(settings.elMessageClass+"-top")
                                .css("left", $elMessageLeft);
                    }
                    else if (settings.side == "bottom"){
                        $elMessage
                                .addClass(settings.elMessageClass+"-bottom")
                                .css("left", $elMessageLeft);
                    }
                }
                else{
                    $el.on('mousemove', function(pos) {
                        $(this).addClass(settings.tipHelp);
                        $elMessage
                                .addClass(settings.elMessageClass+'-fix')
                                .css({top: pos.clientY+settings.elMessageFixIndent, left: pos.clientX+settings.elMessageFixIndent});
                    });
                }
                if (settings.hover) {
                    $el.hover(function(){
                        $elMessage.toggle();
                    })
                }
            });

        };
    };
    // Launch plugin
    $.fn.tooltip = function( options ){
        return this.each(function(){
            $( this ).data( "tooltip", new tooltip()._init( this, options ) );
        });
    };
})(jQuery);