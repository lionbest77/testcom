<? 
    include('inc/get_user_data.php');
    
    if ((bool)$user_data_array == false)
    {
        echo "Нет данных о пользователях";
    }
    else
    {
?>
    <div class="statistics">
    <div class="header_value"><h3>Данные для теста</h3> (из файла data/user_info.json "status value: new/received")</div>
        <?
            $user_data_file = file_get_contents($filename);
            $user_data_array = json_decode($user_data_file, true);

            foreach ($user_data_array as $val => $data) 
            {
        ?>
            <div class="user_cell">
                <div class="user_name"><span>Login: </span><?=$val?></div>
                <div class="user_status"><span>Status: </span><?=$data['status']?></div>
                <div class="user_bonuses"><span>Bonuses count: </span><?=$data['bonuses']?></div>
            </div>
        <? } ?>        
        <div id="js-set_default">Set default</div>
    </div>
<? } ?>
