$(document).ready(function(){
    // hide placeholder when focus in input field

    $('[placeholder]').focus(function(){
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder','');
    }).blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
    })

    // toggle the sous menu of the admin dashboard

    $('.sous-menu-name').click(function(){
        $(this).siblings('.links').slideToggle();
    })

    // 
})