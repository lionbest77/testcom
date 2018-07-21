$( document ).ready(function() {
    $('#js-auth_button').click(function() 
    {
        $('.js-info_message').html('');
                
        var login_name = $('#js-login_field').val();        
        
        if(login_name == '')
        {
            $('.js-info_message').html('Введите login');
        }
        else
        {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url:'auth.php',
                data:'login_name='+login_name,
                success:function(data)
                {
                    if ($.isEmptyObject(data['error']))
                    {
                        $('.wrap').hide();
                        $('.js-info_message').html('Добро пожаловать - '+data['name']+ '. На Вашем счету:'+data['bonuses']+' баллов.');    
                        if (data['status'] == 'new')
                        {
                            $('.js-info_message').append('<div class="js-bonus_info">Приз еще не получен</div>'); 
                            get_bonuses_button();   
                        }
                        else
                        {
                            $('.js-info_message').append('<div>Приз уже получен</div>');
                        }
                    }
                    else
                    {
                        $('.js-info_message').html(data['error']);                        
                    }
                }
            });
        }
    });
    

    function get_bonuses_button()
    {
            $.ajax({
                type: 'POST',
                url:'bonuses_button.php',
                success:function(data)
                {
                    $('.js-user_block').html(data);     
                    button_action();               
                }
            });
    }
    
    function button_action()
    {
        $('#js-want_bonus').click(function() 
        {
            generate_bonuses();            
        });
        
        $('#js-no_bonus').click(function() 
        {
            $('.js-user_block').html('Вы отказались от приза');
        });                    
    }
    
    function generate_bonuses()
    {
            $.ajax({
                type: 'POST',
                url:'generate_bonuses.php',
                data:
                {
                    login_name  : $('#js-login_field').val(),
                    action      : 'update'                        
                },
                success:function(data)
                {
                    $('.js-bonus_info').remove();
                    $('.js-user_block').html(data);
                         
                    $('#js-refresh').click(function() {
                        location.reload();        
                    });                    
                }
            });
    }
    
    $('#js-set_default').click(function() 
    {
            $.ajax({
                type: 'POST',
                url:'set_default.php',
                success:function(data)
                {
                    location.reload();     
                }
            });        
    });

});