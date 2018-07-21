<? 
    include('inc/get_user_data.php');

    $user_data = array();
    
    $action = FALSE;
    
    if ((isset($_POST['action'])) && ($_POST['action'] == 'update'))
    {
        $action = TRUE;          
    }

    if ((bool)$user_data_array == false)
    {
        $user_data['error'] = "Нет данных о пользователях";
    }
    else
    {
        if ($action == TRUE)
        {
            $filename = 'data/user_info.json';
            $user_name = $_POST['login_name'];
            $user_data_array[$user_name]['status'] = 'received';
            
            file_put_contents($filename,json_encode($user_data_array));
        }
        else
        {
            if (isset($_POST['login_name']))
            {
                $check_exist_user = false;
        
                foreach ($user_data_array as $val => $data)
                {
                    if ($val == $_POST['login_name'])
                    {
                        $check_exist_user = true;
                        $user_data['name'] = $val;  
                        $user_data['status'] = $data['status'];
                        $user_data['bonuses'] = $data['bonuses'];
                    }    
                }
            
                if ($check_exist_user != true)
                {
                    $user_data['error'] = "Не существующий пользователь";                
                }        
            }
            else
            {
                $user_data['error'] = "Введите login";            
                        
            }            
            
        }
        

?>
<? } 
    if ($action == FALSE) echo json_encode($user_data);
?>