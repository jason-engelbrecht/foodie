//appear on scroll
$(document).ready(function() {
    //every time window is scrolled
    $(window).scroll( function(){

        //check location of each desired element
        $('.hideme').each( function(){
            let bottom_of_object = $(this).offset().top + $(this).outerHeight();
            let bottom_of_window = $(window).scrollTop() + $(window).height();

            //if object is completely visible in window, fade in
            if( bottom_of_window > bottom_of_object ){
                $(this).animate({'opacity':'1'},500);
            }
        });
    });
});

//strike through ingredients
$(document).ready(function() {
    $(".check").on('click', function() {
        $(this).toggleClass("strike");
        $(this).find('i').toggleClass('fa-check-square fa-square')
    });
});