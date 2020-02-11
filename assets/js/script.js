$('.ns-menu .collapse_btn').click(function(){
    
    $(this).toggleClass('open');
    $(this).parent().parent().children('ul').slideToggle();
    
    return false;
});