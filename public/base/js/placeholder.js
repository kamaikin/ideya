(function($){
    $("input[placeholder], textarea[placeholder]").each(function(){
        var that = this;
        if (hasClass(document.documentElement, 'ie')) {
            if (that.placeholder && 'placeholder' in document.createElement(that.tagName)) return;
        };
        var placeholder = that.getAttribute('placeholder'),
            input = $(that),
            placeholderClass = 'text-placeholder';
        if (that.value === '' || that.value == placeholder) {
            input.addClass(placeholderClass);
            that.value = placeholder;
        }
        input
        .focus(function(){
            if (input.hasClass(placeholderClass)) {
                this.value = '';
                input.removeClass(placeholderClass)
            }
        })
        .blur(function(){
            if (this.value === '') {
                input.addClass(placeholderClass);
                this.value = placeholder;
            } else {
                input.removeClass(placeholderClass);
            }
        });
        that.form && jQuery(that.form).submit(function(){
            if (input.hasClass(placeholderClass)) {
                that.value = '';
            }
        });
    });
})($);