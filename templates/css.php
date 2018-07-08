<link href="/design/css/bootstrap.min.css" rel="stylesheet">
<link href="/design/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="/design/css/awesome-bootstrap-checkbox.css" rel="stylesheet">
<link href="/design/css/animate.css" rel="stylesheet">
<link href="/design/css/beta.css" rel="stylesheet">
<link href="/design/css/style.css" rel="stylesheet">
<link href="/design/css/my.css" rel="stylesheet">
<style>
   li {
   list-style-type: none; /* Убираем маркеры */
   }
  </style>

<script src="/design/js/jquery-2.1.1.js"></script>
<script src="/design/js/bootstrap.min.js"></script>
<script src="/design/js/main.js"></script>

<script src="/design/js/sender.js"></script>

<link rel="shortcut icon" href="/design/favicon.ico" type="image/x-icon" />

<script type="text/javascript" src="//vk.com/js/api/openapi.js?152"></script>
<script type="text/javascript">
    VK.init({apiId: <?=VK_COMMENTS_ID?>, onlyWidgets: true});
</script>
<script type="text/javascript"> 
VK.Widgets.CommunityMessages("vk_community_messages", <?=VK_COMMUNITY_ID?>, {tooltipButtonText: "<?=VK_START_TEXT?>"}); 
</script>   

<link href="/design/p/footable/css/footable.bootstrap.min.css" rel="stylesheet">
<script src="/design/p/footable/js/footable.js"></script>

<script src="/design/p/notify/bootstrap-notify.js"></script>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>