<?
    include('inc/get_user_data.php');
    
    if ((bool)$user_data_array == false)
    {
        $error = "��� ������ � �������������";
    }
    else
    {
        foreach ($user_data_array as $val => $data)
        {
            $user_data_array[$val]['status'] = 'new';
        }
        
        $filename = 'data/user_info.json';
        file_put_contents($filename,json_encode($user_data_array));
                        
    }
?>