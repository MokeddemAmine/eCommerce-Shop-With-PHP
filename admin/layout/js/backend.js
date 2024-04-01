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
    // toggle mode of view for categories 
    $('.categories .view-mode').click(function(){
        $(this).addClass('active').siblings('.view-mode').removeClass('active');
        if($(this).data('mode') == 'classic'){
            $('.categories .category .category-info').slideUp(200);
        }else{
            $('.categories .category .category-info').slideDown(200);
        }
    })
    // toggle one category
    $('.categories .category .category-title').click(function(){
        $(this).siblings('.category-info').slideToggle(200);
    })

    // image with bootstrap style
    $('.custom-file-input').on('change',function(){
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    })
    // change the subcategory 
    var catid = $('#item-catid-create');
    var subcat = $('#item-subcatid-create');
    catid.change(function(){
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                let data = JSON.parse(this.response);
                subcat.html('<option hidden>None</option>');
                data.map(e => {
                    subcat.append('<option value="'+e.CatID+'">'+e.Name+'</option>');
                })
            }
        }
        xhr.open('GET','APICat.php?catid='+$(this).val(),false);
        xhr.send();
    })

    // delete image from edit item in admin
    let n = 1;
    $('.img-item .close').click(function(){
        var deletedImgs = $(this).siblings('img').attr('src');
        $(this).parents('.show-img-item').remove();
        
        $('.imgs-item').append('<input type="hidden" name="imgDelete'+n+'" class="img-deleted" value="'+deletedImgs+'">');
        n++;
    })

    // submit the form language
    $('#languageSelect').change(function(){
        $('#languageForm').submit();
    })
    
})