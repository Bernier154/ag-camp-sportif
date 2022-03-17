(function($){
    
    $('.burger-toggle').click(function(){
        $('.main-nav').toggleClass('open');
    });

    $(window).on('load scroll', function(){
        var y = $(this).scrollTop(); //la distance de scroll
        header = $(".navbar-wrapper");
        heightToSticky = $('#masthead').innerHeight();

        if(y >= heightToSticky)  {
            if(!header.hasClass('sticky')){
                header.addClass('sticky');
            }
        }else {
            if(header.hasClass('sticky')){
                header.removeClass('sticky');
            }
        }	
	});

    $('.banner .double-arrow-imager-wrapper img').click(function(){
        $('html, body').animate({
            scrollTop: $("#primary").offset().top - 50
        }, 100, "linear");
    });

})(jQuery);