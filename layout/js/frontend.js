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
    // display the section of result of search 
    $('#search').focus(function(){
        $('#result-search').css('display','block');
        // print result of search from items and categories
    })
    $('#search').keyup(function(){
        console.log('repeat');
        $('#result-search').children('a').remove();
        $.ajax({
            method:'GET',
            url:'APISearch.php',
            data:{
                search:$(this).val()
            },
            success:function(data){
                let result = JSON.parse(data);
                console.log(result);
                result.map(res => $('#result-search').append(res));
            },
            error:function(xhr,status,err){
                console.log(err);
            }
        })
    })
    $('body').children().not('header').click(function(){
        $('#search').val('');
        $('#result-search').children('a').remove();
        $('#result-search').css('display','none');
    })

   // change total price when change number of unit of item
   $('#number-unit-item').change(function(){
    $('#price-item').text(parseFloat($('#unit-price-item').text())*parseInt($(this).val()));

   })
   $('#number-unit-item').keyup(function(){
    $('#price-item').text(parseFloat($('#unit-price-item').text())*parseInt($(this).val()));

   })
   // show and hide method of payment
   $('.click-payment').click(function(){
    $('#'+$(this).data('class')).slideToggle(100);
    $('.method-payment').not('#'+$(this).data('class')).hide();
    
   })
    
})