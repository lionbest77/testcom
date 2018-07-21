<? 
    include('inc/get_user_data.php');
    include('auth.php');

    function generate_value($min,$max)
    {
        $value = rand($min,$max);
        return $value;    
    }
    
    $filename = 'data/bonuses_info.json';
    
    if (file_exists($filename)) 
    { 
        $bonuses_data_file = file_get_contents($filename);
        $bonuses_data_array = json_decode($bonuses_data_file, true);

        $money_count = (int)$bonuses_data_array['money']['count'];
        $gifts_count = (int)$bonuses_data_array['gifts']['count'];
    
        $data_for_random = array('points');
    
        if ($money_count > 0)
        {
            $data_for_random[] = 'money';        
        }
    
        if ($gifts_count > 0)
        {
            $data_for_random[] = 'gifts';        
        }     
    
        $rand_keys = array_rand($data_for_random);
    
        $bonuses_data_array[$data_for_random[$rand_keys]]['count']--;
    
        file_put_contents($filename,json_encode($bonuses_data_array));
        
        $bonuses_value = 0;
        
        switch ($data_for_random[$rand_keys]) {
            case 'money':
                $min = $bonuses_data_array['money']['min'];
                $max = $bonuses_data_array['money']['max'];
                $bonuses_value = generate_value($min,$max);     
            ?>
                <div>Вы выиграли денежный приз в размере <?=$bonuses_value?></div>
                <input type="button" value="На счет лояльности" id="js-add_user_points"/>
                <form action="bank_api">
                    <input type="button" value="Банковский перевод" id="js-check_out"/>
                </form>
            <?                       
                break;
                
            case 'points':
                $min = $bonuses_data_array['points']['min'];
                $max = $bonuses_data_array['points']['max'];
                $bonuses_value = generate_value($min,$max);

                if (isset($_POST['login_name']))
                {
                    $filename = 'data/user_info.json';
                    $user_name = $_POST['login_name'];
                    $user_data_array[$user_name]['bonuses'] = (int)$user_data_array[$user_name]['bonuses'] + $bonuses_value;
            
                    file_put_contents($filename,json_encode($user_data_array));                    
                }    
                
            ?>
                <div>Вы выиграли бонусные баллы в размере <?=$bonuses_value?></div>
            <?                            
                break;
                
            case 'gifts':
            ?>
                <div>Вы выиграли приз</div>
                <div>Наши операторы свяжутся с Вами в ближайшее время</div>
            <?            
                break;
        }        
        ?>
            <input type="button" value="HOME" id="js-refresh"/>        
        <?
    }
    else
    {
        $bonuses_data_array = false;        
    }
?>