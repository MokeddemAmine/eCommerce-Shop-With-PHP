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

// live show when add new item
$(document).ready(function(){
    $('.input-change').keyup(function(){
        $('.card .'+$(this).attr('name')).text($(this).val());
    })
    $('.input-change-currency').change(function(){
        $('.card .currency').text($(this).val());
    })
})
 // confirm delete 
 $('.confirm-delete').click(function(){
    return confirm('Are you sure want to delete this ?');
})
// change sub categories 
$(document).ready(function(){
    var cat = $('#category-item');
    var subcat = $('#sub-category-item');
    cat.change(function(){
        $.get('admin/APICat.php?catid='+cat.val(),function(data){
            var result = JSON.parse(data);
            subcat.html('<option hidden>Sub Category</option>');
            result.map(e => {
                subcat.append('<option value="'+e.CatID+'">'+e.Name+'</option>');
            })
        })
    })
})