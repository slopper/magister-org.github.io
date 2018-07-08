<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Статистика магазина</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Главная страница</a>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">

    </div>
</div>

<div class="wrapper wrapper-content">
    <center><h1>Статистика продаж</h1></center>
    <?php
        $dateYesterday = date('Y-m-d',strtotime(date('Y/m/d') . "-1 days"));
        $dateYesterday1 = date('Y-m-d',strtotime(date('Y/m/d') . "-2 days"));
        $rubMonth = floor(mysqli_get_query("SELECT SUM(`sum`) FROM `freekassa_payments` WHERE `dateComplete` LIKE '".date("Y-m")."%';")['SUM(`sum`)']);
        $rubToday = floor(mysqli_get_query("SELECT SUM(`sum`) FROM `freekassa_payments` WHERE `dateComplete` LIKE '".date("Y-m-d")."%';")['SUM(`sum`)']);
        $rubYesterday = floor(mysqli_get_query("SELECT SUM(`sum`) FROM `freekassa_payments` WHERE `dateComplete` LIKE '".$dateYesterday."%';")['SUM(`sum`)']);
        $rubYesterday1 = floor(mysqli_get_query("SELECT SUM(`sum`) FROM `freekassa_payments` WHERE `dateComplete` LIKE '".$dateYesterday1."%';")['SUM(`sum`)']);

        $logiInfo = mysqli_get_query("SELECT SUM(`price`),SUM(`count`) FROM `orders` WHERE `dateComplete` LIKE '".date("Y-m-d")."%';");
        $logiTodayCount = floor($logiInfo['SUM(`count`)']);
        $logiTodayRUB = floor($logiInfo['SUM(`price`)']);
        $logiInfo = mysqli_get_query("SELECT SUM(`price`),SUM(`count`) FROM `orders` WHERE `dateComplete` LIKE '".$dateYesterday."%';");
        $logiYesterdayCount = floor($logiInfo['SUM(`count`)']);
        $logiYesterdayRUB = floor($logiInfo['SUM(`price`)']);
        $logiInfo = mysqli_get_query("SELECT SUM(`price`),SUM(`count`) FROM `orders` WHERE `dateComplete` LIKE '".$dateYesterday1."%';");
        $logiYesterday1Count = floor($logiInfo['SUM(`count`)']);
        $logiYesterday1RUB = floor($logiInfo['SUM(`price`)']);
        $logiInfo = mysqli_get_query("SELECT SUM(`price`),SUM(`count`) FROM `orders` WHERE `dateComplete` LIKE '".date("Y-m")."%';");
        $logiMonthCount = floor($logiInfo['SUM(`count`)']);
        $logiMonthRUB = floor($logiInfo['SUM(`price`)']);
    ?>

    <div class="ibox animated fadeIn">
        <div class="ibox-content">        
          <table class="table table-bordered">
            <thead>
              <tr>
                <th></th>
                <th>Пополнение баланса</th>
                <th>Продано логов</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>За сегодня</td>
                <td><span class="spincrement"><?=$rubToday?></span> руб.</td>
                <td><span class="spincrement"><?=$logiTodayCount?></span> строк, на <span class="spincrement"><?=$logiTodayRUB?></span> руб.</td>
              </tr>
              <tr>
                <td>За вчера</td>
                <td><span class="spincrement"><?=$rubYesterday?></span> руб.</td>
                <td><span class="spincrement"><?=$logiYesterdayCount?></span> строк, на <span class="spincrement"><?=$logiYesterdayRUB?></span> руб.</td>
              </tr>
              <tr>
                <td>За позавчера</td>
                <td><span class="spincrement"><?=$rubYesterday1?></span> руб.</td>
                <td><span class="spincrement"><?=$logiYesterday1Count?></span> строк, на <span class="spincrement"><?=$logiYesterday1RUB?></span> руб.</td>
              </tr>
              <tr>
                <td>За месяц</td>
                <td><span class="spincrement"><?=$rubMonth?></span> руб.</td>
                <td><span class="spincrement"><?=$logiMonthCount?></span> строк, на <span class="spincrement"><?=$logiMonthRUB?></span> руб.</td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>

    <div class="ibox animated fadeIn">
        <div class="ibox-content">                
        	<canvas id="balanceStat" height="70px"></canvas>
        </div>
    </div>


    <?
    	$aDate = array();
    	$aCount = array();

    	for($i = 9; $i >= 0; $i--){
    		$date = date('Y-m-d',strtotime(date('Y/m/d') . "-{$i} days"));
    		$rub = floor(mysqli_get_query("SELECT SUM(`sum`) FROM `freekassa_payments` WHERE `dateComplete` LIKE '".$date."%';")['SUM(`sum`)']);

    		array_push($aDate, $date);
    		array_push($aCount, $rub);
    	}
    ?>

    <script>
		var ctx = document.getElementById("balanceStat").getContext('2d');
		var myChart = new Chart(ctx, {
		    type: 'line',
		    data: {
		        labels: <?=json_encode($aDate)?>,
		        datasets: [{
		            label: 'Пополнение баланса',
		            data: <?=json_encode($aCount)?>,
		            backgroundColor: 'rgba(255, 99, 132, 0.2)',
		            borderColor: 'rgba(255,99,132,1)',
		            borderWidth: 1
		        }]
		    },
		    options: {
		        scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero:true
		                }
		            }]
		        }
		    }
		});
	</script>

</div>
