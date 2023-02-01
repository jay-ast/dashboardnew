<script type="text/javascript">
<!--
$(document).ready(function() {
	var	site_chart = new Highcharts.Chart({
    	chart: {
        	renderTo: 'site-chat',
            defaultSeriesType: 'column',
            backgroundColor: '#f7f7f7',
            zoomType: 'xy'
		},
        legend: {
        	enabled: true
		},
        plotOptions: {
        	column: {
            	borderWidth: 0,
                pointPadding: 0,
			},
            series: {
            	dataLabels: {
	                enabled: false
				}
			}
		},
	    series: [{
		    	color: '#215868',
		        name: 'Total Users',
		        data: <?php echo json_encode($total_users);?>,
		        type: 'line',
		        index: 1
			},{
		    	color: '#F00',
		        name: 'New joined Users',
		        data: <?php echo json_encode($new_users);?>,
		        type: 'line',
		        index: 1
			},{
		    	color: '#0F0',
		        name: 'Logined Users',
		        data: <?php echo json_encode($login_users);?>,
		        type: 'line',
		        index: 1
			}
		],
	    title: {
	    	text: '<?php echo $fromday?> ~ <?php echo $today?>',
		},
	    tooltip: {
	    	enabled: true
		},
	    xAxis: {
	    	categories: <?php echo json_encode($chart_dates);?>,
	        labels: {
	        	rotation: -90,
	            y: 5,
	            align: 'right',
	            style: {
	            	font: 'normal 10px Verdana, sans-serif'
				}
			}
		},
	    yAxis: {
	    	title: {
	        	text: ''
	        },
			min: 0
		}
	});
});
//-->
</script>

<article class="module width_3_quarter">
	<header>
		<h3>The <?php echo SITE_TITLE?> Statistics</h3>
		<div style="float: right; padding: 8px 10px;" id="date_time"></div>
	</header>
	<div id="site-chat" class="chat-box"></div>
	<footer>
		<div class="submit_link">
			<form method="post">
				<input type="text" name="fromday" value="<?php echo $fromday?>" class="input_date" />
				&nbsp;&nbsp;&nbsp;~
				<input type="text" name="today" value="<?php echo $today?>" class="input_date" />
				<input type="submit" value="Filter" class="alt_btn">
			</form>
		</div>
	</footer>
</article>

<?php 
$users = new User();
?>
<article class="stats_overview" style="float: left; margin: 20px 0 0 3%;">
	<div class="overview_today">
		<p class="overview_day">Users</p>
		<p class="overview_count"><?php echo number_format($users->where("group_id", 2)->count())?></p>
		<p class="overview_type">All</p>
		<p class="overview_count"><?php echo number_format($users->where("actived", 'N')->where("group_id", 2)->count())?></p>
		<p class="overview_type">Blocked</p>
		<p class="overview_count"><?php echo number_format($users->where("status", "online")->where("group_id", 2)->count())?></p>
		<p class="overview_type">Online</p>
	</div>
</article>