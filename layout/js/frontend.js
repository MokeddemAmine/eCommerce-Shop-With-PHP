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
    // live show for image
    $('.add-image-item').change(function(){
        let file = this.files[0];
        let format = ['image/jpeg','image/png','image/jpg','image/gif'];

        if( format.indexOf(file.type) === -1){
            
            alert('type of image not supported')
            this.value = ''
            return;
        }
        if(file.size > 2 * 1024 * 1024){
            alert('image not exced more than 512Kb');
            this.value = ''
            return
        }
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(){
             $('.imagine-image-item').attr('src',reader.result);
        }

        reader.onerror = function(){
            $('#imagine-image-item').attr('src','imgs/item.jpg')
            alert('error !!');
        }
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

    // delete image from edit item
    let n = 1;
    $('.img-item .close').click(function(){
        var deletedImgs = $(this).siblings('.img').children('img').attr('src');
        $(this).parents('.show-img-item').remove();
        
        $('.imgs-item').append('<input type="hidden" name="imgDelete'+n+'" class="img-deleted" value="'+deletedImgs+'">');
        n++;
    })
    // change the value of lang in html tag
    // submit the form language
    $('#languageSelect').change(function(){
        if($(this).val() == 'english'){
            $('html').attr('lang','en');
        }else if($(this).val() == 'french'){
            $('html').attr('lang','fr');
        }
        console.log($('html').attr('lang'));
        $('#languageForm').submit();
    })
    
})