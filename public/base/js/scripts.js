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

}); // Ready