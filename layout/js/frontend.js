// submit the form of categories automatically when changed the select 
$(document).ready(function(){
    $('#cat-menu').change(function(){
        $(this).parent().submit();
    })
})

// toggle the login and register between them
$(document).ready(function(){
    $('.register-go').click(function(){
        $('.register').slideDown(200);
        $('.login').slideUp(200);
    })
    $('.login-go').click(function(){
        $('.login').slideDown(200);
        $('.register').slideUp(200);
        
    })
})