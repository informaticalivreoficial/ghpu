$(function () {
    //Shadowbox.init();


    var action = setInterval(slideGo, 3000);

    $('.slide_nav.go').click(function () {
        clearInterval(action);
        slideGo();
    });

    $('.slide_nav.back').click(function () {
        clearInterval(action);
        slideBack();
    });

    function slideGo() {
        if ($('.slide_item.first').next().size()) {
            $('.slide_item.first').fadeOut(400, function () {
                $(this).removeClass('first').next().fadeIn().addClass('first');
            });
        } else {
            $('.slide_item.first').fadeOut(400, function () {
                $('.slide_item').removeClass('first');
                $('.slide_item:eq(0)').fadeIn().addClass('first');
            });
        }
    }

    function slideBack() {
        if ($('.slide_item.first').index() >= $('.slide_item').length) {
            $('.slide_item.first').fadeOut(400, function () {
                $(this).removeClass('first').prev().fadeIn().addClass('first');
            });
        } else {
            $('.slide_item.first').fadeOut(400, function () {
                $('.slide_item').removeClass('first');
                $('.slide_item:last-of-type').fadeIn().addClass('first');
            });
        }
    }  
    
    
     
}); // Fecha Função Principal