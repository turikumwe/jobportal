


(function(root, factory) {
    // CommonJS support
    if (typeof exports === 'object') {
        module.exports = factory();
    }
    // AMD
    else if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    }
    // Browser globals
    else {
        factory(root.jQuery);
    }
}(this, function($) {
    'use strict';

    var dom = {
        base: '.kak-fieldset',
        content: '.content-fieldset',
        legend :'legend',
        act : '.act-fieldset'
    };

    // **********************************
    // Constructor
    // **********************************
    var kakFieldSet = function(element, options) {
        this.$parent = $(element)
        var defaultOptions = {speed: this.$parent.data('speed') };
        this.options  = $.extend(defaultOptions,options);

        this.$parent.find(dom.legend).css('cursor','pointer');

        this.$parent.on('click',dom.legend,$.proxy(function(e){
            this.onHandleClickLegent(e);
        },this));

    };

    kakFieldSet.prototype = {
        constructor: kakFieldSet,
        // ----------------------------------
        // Methods to override
        // ----------------------------------
        onHandleClickLegent: function(e) {
            var legend = $(e.target),
                act = legend.find(dom.act),
                content = this.$parent.find(dom.content);

            content.stop().slideToggle(this.options.speed, function() {
                var value = content.css('display') == 'block' ? act.data('up') :  act.data('down')
                act.html(value);
            });


        }
    };

    $.fn.kakFieldSet = function(option) {
        var options = typeof option == 'object' && option;
        new kakFieldSet(this, options);
        return this;
    };
    $.fn.kakFieldSet.Constructor = kakFieldSet;

    // auto init
    $(dom.base).each(function(k,i){
        $(i).kakFieldSet();
    });


}));



/*
(function(){

    $("legend").css("cursor","pointer").click(function(){
        var legend = $(this);
        var
        if(value=="[-]")
            value="[+]";
        else
            value="[-]";
        $(this).siblings().slideToggle("slow", function() { legend.children("span").html(value); } );
    });

})(jQuery)*/