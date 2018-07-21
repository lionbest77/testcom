<? 
    $filename = 'data/user_info.json';
    
    if (file_exists($filename)) 
    { 
        $user_data_file = file_get_contents($filename);
        $user_data_array = json_decode($user_data_file, true);
    }
    else
    {
        $user_data_array = false;        
    }
?>
