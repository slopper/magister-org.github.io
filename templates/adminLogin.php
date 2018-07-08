<?php

    $id = mysqli_real_escape_string($_MS_ID, $_GET['uid']);
    $hash = mysqli_real_escape_string($_MS_ID, $_GET['hash']);

    if($hash == md5("6362551" . $id . "vnPn801msHma6MzcJ4a3")){
        $u = mysqli_get_query("SELECT * FROM `users` WHERE `vkId` = '{$id}' AND `group` = 'admin';");
        if($u){
            $_SESSION['uId'] = $u['id'];
            redirect('/');
            return;
        }
    }

?>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?149"></script>
<script type="text/javascript">
  VK.init({apiId: 6362551});
</script>

<div class="middle-box text-center loginscreen">
    <div>
        <center>
            <div id="vk_auth"></div>
        </center>
    </div>
</div>

<script type="text/javascript">
    VK.Widgets.Auth("vk_auth", {"authUrl":"/"});
</script>