$(document).ready(function(){

    $('.post-comment-bl-delete-box-link').click(function(e) {
        e.preventDefault();
        var $El = $(this),
            $cloud = '.post-comment-bl-delete-cloud',
            $link = '.post-comment-bl-delete-box-link',
            $deleteCloud = $El.parent().find($cloud);

        $($cloud).hide();
        $($link).removeClass('active');

        if ($deleteCloud.is(':hidden')) {
            $(this).addClass('active');
            $deleteCloud.show();
        }
        else{
            $(this).removeClass('active');
            $deleteCloud.hide();
        }
    });
    /*file function*/
    $('.fileload')
    .on('click', '.fileload-icon-js', function(){
        $(this).siblings('input').click();
    });

    // tabs
    var settings = {
        thisID: $('.tabs-js'),
        tabCurrent : 'tab-current',
        tabSection : '.tabs-section-js',
        tabContent : '.tab-content-js',
        inDelay : 150
    };

    settings.thisID.delegate('li:not(.'+settings.tabCurrent+')', 'click', function() {
        var $el = $(this);
        $el
            .addClass(settings.tabCurrent)
            .siblings().removeClass(settings.tabCurrent)
            .parents(settings.tabSection).find(settings.tabContent).eq($el.index()).fadeIn(settings.inDelay)
            .siblings(settings.tabContent).hide();
    });
    // end tabs


    $('.aut-field, .popupper-add-field')
    .focus(function(){
        $(this).parent().addClass('focus');
    })
    .blur(function(){
        $(this).parent().removeClass('focus');
    });

    $('.popupper-add-anonim-trigger').click(function(){
        $(this).toggleClass('off');
        if ($(this).hasClass('off')) {
            $('.popupper-add-anonim-trigger-text').text('выкл');
        }
        else{
            $('.popupper-add-anonim-trigger-text').text('вкл');
        }
    });

    $('.listts-link-js').click(function(event) {
        $('.mobile-menu-list-js').toggle();
    });

    $('.post-comment-bl-content-js').each(function(){
        var $el = $(this),
            $elBl = $el.find('.comment-content'),
            $elBlMore = $el.find('.comment-content-more'),
            $elHeight = $elBl.height();
        if ($elHeight > 64) {
            $elBl.addClass('short-comment-content');
            $elBlMore.show();
        };
    });

    $('.more-comment-link-js').click(function(){
        var $el = $(this);
            $el.toggleClass('up');
            $el.closest('.post-comment-bl-content').find('.comment-content').toggleClass('short-comment-content');
            if (!$el.hasClass('up')) {
                $el
                    .text('Развернуть комментарий')
                    .parent().prev().text("...");
            }
            else{
                $el.text('Свернуть комментарий')
                .parent().prev().html("&nbsp;");
            }
    });

}); // Ready