$(document).ready(function(){
    
//    $('#corps').corner("15px");
//    $('#menuGauche').corner("left 13px");
//    $('#toolbar').corner("14px top");
//    $('#centrale').corner("14px bottom");
//    $('#menuHaut').corner("14px bottom");
//    $('.subMenu').corner("5px");
//    $('#footer').corner("14px top");
     
    /***RECHERCHE*****************************/
    $('#search input').css('width','0px');
    $('#search input').css('opacity', '0');
    
    $('#search input').focusin(function(){
        $('#search input').animate({
            width: '200px', 
            opacity: '1'
        }, "slow");
    });
    
    $('#search img[alt="search"]').mouseover(function(){
        $('#search input').focus();
    });
    
    $('#search input').focusout(function(){
        $('#search input').animate({
            width: '0px', 
            opacity: '0'
        }, "slow");
    });
    /*************************************/
    
    $('#search a[class^="font-size-"]').click(function(){
         
        if($(this).attr('class') === 'font-size-up'){
            $('body').css('font-size','large');
            $(this).attr('class', 'font-size-upx');
        }
        else{
            if($(this).attr('class') === 'font-size-upx'){
                $('body').css('font-size','x-large');
                $(this).attr('class', 'font-size-downx');
            }
            else{
                if($(this).attr('class') === 'font-size-downx'){
                    $('body').css('font-size','small');
                    $(this).attr('class', 'font-size-down');
                }
                else{
                    if($(this).attr('class') === 'font-size-down'){
                        $('body').css('font-size','14px');
                        $(this).attr('class', 'font-size-up');
                    }
                }
            }
        }
        
    })
    /***************************************/
    $('#search input').keyup(function(e){

            
        $.each($('#contenu b'), function(){
            $(this).after($(this).html());
            $(this).remove();
        })
            
                
        tab = $('#search input').val().split(' ');

        $.each(tab, function(key,value){
                
            if(value.replace(' ','').length > 1){
                regexp = new RegExp(value, "gi"); 
                
                $.each($('#contenu .titleRadio'), function(){
                    $(this).html($(this).html().replace(regexp,'<b>'+value+'</b>'));
                })
            }
        })
            
    });
    
    /***************************************/
    
    $('#contenu input').css('border','1px solid #CCC');

    
})

function afficheRadio(idRadio){

    var params = {
        radio: idRadio
    };
    var atts = null;
    swfobject.embedSWF("streamPlayer.swf?radio="+idRadio,
        idRadio, $('#'+idRadio).width(), $('#'+idRadio).height(), "8", null, null, params, atts);
}
