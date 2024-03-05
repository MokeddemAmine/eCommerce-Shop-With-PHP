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

    // confirm delete 
    $('.confirm-delete').click(function(){
        return confirm('Are you sure want to delete this ?');
    })
    // toggle the latest box in dashboard
    $('.toggle-latest').click(function(){
        $(this).parent().siblings('.card-body').slideToggle(200);
        if($(this).hasClass('fa-minus')){
            $(this).removeClass('fa-minus').addClass('fa-plus');
        }else{
            $(this).removeClass('fa-plus').addClass('fa-minus');
        }
    })
})