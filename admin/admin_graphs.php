			<div class="col-12" style="margin-left:0">
                <div id="user-data" class="col-12">
					<div class="row mb-3 pt-3" style="position: sticky; top: 0">
						<h1 class="text-primary col-10">Statistics</h1>
					</div>
					<hr>
					<!-- Nav tabs -->
					<ul class="nav nav-tabs md-tabs nav-justified mdb-color darken-3" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#panel_sales" role="tab">Sales</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#panel_production" role="tab">Production</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#panel_installs" role="tab">Installs</a>
						</li>
					</ul>
					<!-- Tab panels -->
					<div class="tab-content px-0">
						<!--Panel 1-->
						<div class="tab-pane fade in show active" id="panel_sales" role="tabpanel">
							<ul class="nav nav-tabs md-tabs nav-justified mdb-color darken-5" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#tab_salesWeekly" role="tab">Weekly Sales</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#tab_income" role="tab">Value Installed</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#tab_entry" role="tab">Walk-Ins</a>
								</li>
							</ul>
							<div class="tab-content px-0">
								<!--Panel 1-->
								<div class="tab-pane fade in show active" id="tab_salesWeekly" role="tabpanel">
									<div class="row">
										<h2>Install Value</h2>
										<canvas id="salesWeeklyGraph" class="col-12"></canvas>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_income" role="tabpanel">
									<div class="row">
										<h2>Install Value</h2>
										<canvas id="incomeGraph" class="col-12"></canvas>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_entry" role="tabpanel">
									<div class="row">
										<h2>Walk-Ins</h2>
										<canvas id="walkinsGraph" class="col-12"></canvas>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="panel_production" role="tabpanel">
							<ul class="nav nav-tabs md-tabs nav-justified mdb-color darken-5" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#tab_prodWeekly" role="tab">Weekly Production</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#tab_prodDaily" role="tab">Daily Production</a>
								</li>
							</ul>
							<div class="tab-content px-0">
								<!--Panel 1-->
								<div class="tab-pane fade in show active" id="tab_prodWeekly" role="tabpanel">
									<div class="row">
										<h2>Weekly Production</h2>
										<canvas id="prodWeeklyGraph" class="col-12"></canvas>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_prodDaily" role="tabpanel">
									<div class="row">
										<h2>Daily Production</h2>
										<canvas id="prodDailyGraph" class="col-12"></canvas>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="panel_installs" role="tabpanel">
							<ul class="nav nav-tabs md-tabs nav-justified mdb-color darken-5" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#tab_installs_week" role="tab">Installs/Week</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#tab_installs" role="tab">Installs/Day</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#tab_instStart" role="tab">Late Starts</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#tab_instEnd" role="tab">Late Working</a>
								</li>
							</ul>
							<div class="tab-content px-0">
								<!--Panel 1-->
								<div class="tab-pane fade in show active" id="tab_installs_week" role="tabpanel">
									<div class="row">
										<h2>Installs by Week</h2>
										<canvas id="installsWeekGraph" class="col-12"></canvas>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_installs" role="tabpanel">
									<div class="row">
										<h2>Installs by Day</h2>
										<canvas id="installsGraph" class="col-12"></canvas>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_instStart" role="tabpanel">
									<div class="row">
										<h2>Install Late Start</h2>
										<canvas id="instStartGraph" class="col-12"></canvas>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_instEnd" role="tabpanel">
									<div class="row">
										<h2>Install Late Finish</h2>
										<canvas id="instEndGraph" class="col-12"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

<script>
console.log("start");
var $installed = [];
var $costs = [];
var $profit = [];
var $profitPerc = [];
var $walkins = [0,0];
var $converted = [0,0];
var $idate = [];
var $sqft = [];
var $jobs = [];
var $lateStartDate = [];
var $lateStartTot = [];
var $lateStartLate = [];
var $lateStartTime = [];
var $lateEndDate = [];
var $lateEndTot = [];
var $lateEndLate = [];
var $weekInstDate = [];
var $weekInstSqft = [];
var $salesWeeklyAmount = [];
var $salesWeeklyProfPot = [];
var $salesWeeklyProfit = [];
var $salesWeeklyErrors = [];
var $salesWeeklyWeek = [];
var $prodWeeklyWeek = [];
var $prodWeeklyProg = [];
var $prodWeeklySaw = [];
var $prodWeeklyCNC = [];
var $prodWeeklyPolish = [];
var $prodDailyDay = [];
var $prodDailyProg = [];
var $prodDailySaw = [];
var $prodDailyCNC = [];
var $prodDailyPolish = [];

<? 
	$get_prod_daily_stats = new project_action;
	foreach($get_prod_daily_stats->get_prod_daily_stats() as $results) {
		?>
		$prodDailyDay.push ('<?= date("m/d/y", strtotime($results['day'])) ?>');
		$prodDailyProg.push (<?= $results['prod_prog'] ?>);
		$prodDailySaw.push (<?= $results['prod_saw'] ?>);
		$prodDailyCNC.push (<?= $results['prod_cnc'] ?>);
		$prodDailyPolish.push (<?= $results['prod_polish'] ?>);
		<?
	}

	$get_prod_weekly_stats = new project_action;
	foreach($get_prod_weekly_stats->get_prod_weekly_stats() as $results) {
		?>
		$prodWeeklyWeek.push ('<?= date("m/d/y", strtotime($results['week_beginning'])) ?>');
		$prodWeeklyProg.push (<?= $results['prod_prog'] ?>);
		$prodWeeklySaw.push (<?= $results['prod_saw'] ?>);
		$prodWeeklyCNC.push (<?= $results['prod_cnc'] ?>);
		$prodWeeklyPolish.push (<?= $results['prod_polish'] ?>);
		<?
	}

	$get_sales_weekly_stats = new project_action;
	foreach($get_sales_weekly_stats->get_sales_weekly_stats() as $results) {
		$repCost = $results['sales_weekly_repair'] + $results['sales_weekly_rework'];
		$potentialProfit = $results['sales_weekly_profit'] - $repCost;
		?>
		$salesWeeklyWeek.push ('<?= date("m/d/y", strtotime($results['week_beginning'])) ?>');
		$salesWeeklyAmount.push (<?= $results['sales_weekly_ammount'] ?>);
		$salesWeeklyProfPot.push (<?= $results['sales_weekly_profit'] ?>);
		$salesWeeklyProfit.push (<?= $potentialProfit ?>);
		$salesWeeklyErrors.push (<?= $repCost ?>);
		<?
	}

	$get_inst_stats_week = new project_action;
	foreach($get_inst_stats_week->get_inst_stats_week() as $results) {
		?>
		$weekInstDate.unshift ('<?= date("m/d/y", strtotime($results['statWeek'])) ?>');
		$weekInstSqft.unshift (<?= $results['sqft_count'] ?>);
	console.log($weekInstDate,$weekInstSqft);
		<?
	}

	$get_late_starts = new project_action;
	foreach($get_late_starts->get_late_starts() as $results) {
		?>
		$lateStartDate.push ('<?= date("m/d/y", strtotime($results['startdate'])) ?>');
		$lateStartTot.push (<?= $results['am_pjts'] ?>);
		$lateStartLate.push (<?= $results['overpjt'] ?>);
		var $mins = (<?= $results['sec_late'] ?>) / 60;
		$lateStartTime.push ($mins);
		<?
	}

	$get_late_ends = new project_action;
	foreach($get_late_ends->get_late_ends() as $results) {
		?>
		$lateEndDate.push ('<?= date("m/d/y", strtotime($results['startdate'])) ?>');
		$lateEndTot.push (<?= $results['totalpjt'] ?>);
		$lateEndLate.push (<?= $results['overpjt'] ?>);
		<?
	}

	$get_sales_stats = new project_action;
	foreach($get_sales_stats->get_sales_stats() as $results) {
		?>
		$installed.push(<?= $results['stat'] ?>);
		$costs.push(<?= $results['cost'] ?>);
		$profit.push(<?= $results['profit'] ?>);
		var percentProf = 100 / <?= $results['cost'] ?> * <?= $results['profit'] ?>;
		//percentProfa = parseFloat(percentProf).toFixed(2);
		$profitPerc.push(percentProf);
		<?
	}

	$get_sqft_inst_stats = new project_action;
	foreach($get_sqft_inst_stats->get_sqft_inst_stats() as $results) {
		?>
		$idate.push('<?= date("m/d/y", strtotime($results['idate'])) ?>');
		$sqft.push(<?= $results['sqft'] ?>);
		$jobs.push(<?= $results['jobs'] ?>);
		<?
	}

	$get_walkin_stats = new project_action;
	foreach($get_walkin_stats->get_walkin_stats() as $results) {
		?>
		$walkins.push(<?= $results['walkins'] ?>);
		$converted.push(<?= $results['projects'] ?>);
		<?
	}
?>

var prodDailyGraph = document.getElementById("prodDailyGraph").getContext('2d');
var prodWeeklyGraph = document.getElementById("prodWeeklyGraph").getContext('2d');
var salesWeeklyGraph = document.getElementById("salesWeeklyGraph").getContext('2d');
var installsWeekGraph = document.getElementById("installsWeekGraph").getContext('2d');
var installsGraph = document.getElementById("installsGraph").getContext('2d');
var instStartGraph = document.getElementById("instStartGraph").getContext('2d');
var instEndGraph = document.getElementById("instEndGraph").getContext('2d');
var ctx2 = document.getElementById("walkinsGraph").getContext('2d');
var ctx = document.getElementById("incomeGraph").getContext('2d');
console.log('middle');


var prodDailyChart = new Chart(prodDailyGraph, {
    type: 'bar',
    data: {
        labels: $prodDailyDay.slice(-30),
        datasets: [
			{
				label: 'Programming',
				data: $prodDailyProg.slice(-30),
				backgroundColor: 'rgba(40, 167, 69, 0.2)',
				borderColor: 'rgba(40, 167, 69, 1)',
				borderWidth: 1
			},
			{
				label: 'Saw',
				data: $prodDailySaw.slice(-30),
				backgroundColor: 'rgba(0, 123, 255, 0.2)',
				borderColor: 'rgba(0, 123, 255,1)',
				borderWidth: 1
			},
			{
				label: 'CNC',
				data: $prodDailyCNC.slice(-30),
				backgroundColor: 'rgba(255,193,7, 0.2)',
				borderColor: 'rgba(255,193,7,1)',
				borderWidth: 1
			},
			{
				label: 'Polishing',
				data: $prodDailyPolish.slice(-30),
				backgroundColor: 'rgba(220, 53, 69, 0.2)',
				borderColor: 'rgba(220, 53, 69,1)',
				borderWidth: 1
			}
		]
    },
	options: {
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:false
				}
			}]
		}
	}
});
	
var prodWeeklyChart = new Chart(prodWeeklyGraph, {
    type: 'bar',
    data: {
        labels: $prodWeeklyWeek.slice(-12),
        datasets: [
			{
				label: 'Programming',
				data: $prodWeeklyProg.slice(-12),
				backgroundColor: 'rgba(40, 167, 69, 0.2)',
				borderColor: 'rgba(40, 167, 69, 1)',
				borderWidth: 1
			},
			{
				label: 'Saw',
				data: $prodWeeklySaw.slice(-12),
				backgroundColor: 'rgba(0, 123, 255, 0.2)',
				borderColor: 'rgba(0, 123, 255,1)',
				borderWidth: 1
			},
			{
				label: 'CNC',
				data: $prodWeeklyCNC.slice(-12),
				backgroundColor: 'rgba(255,193,7, 0.2)',
				borderColor: 'rgba(255,193,7,1)',
				borderWidth: 1
			},
			{
				label: 'Polishing',
				data: $prodWeeklyPolish.slice(-12),
				backgroundColor: 'rgba(220, 53, 69, 0.2)',
				borderColor: 'rgba(220, 53, 69,1)',
				borderWidth: 1
			}
		]
    },
	options: {
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:false
				}
			}]
		}
	}
});
	
var salesWeeklyChart = new Chart(salesWeeklyGraph, {
    type: 'line',
    data: {
        labels: $salesWeeklyWeek.slice(-18),
        datasets: [
			{
				label: 'Weekly Sales',
				data: $salesWeeklyAmount.slice(-18),
				backgroundColor: 'rgba(40, 167, 69, 0.2)',
				borderColor: 'rgba(40, 167, 69, 1)',
				borderWidth: 1
			},
			{
				label: 'Potential Profit',
				data: $salesWeeklyProfPot.slice(-18),
				backgroundColor: 'rgba(255, 193, 7, 0.2)',
				borderColor: 'rgba(255, 193, 7, 1)',
				borderWidth: 1
			},
			{
				label: 'Actual Profit',
				data: $salesWeeklyProfit.slice(-18),
				backgroundColor: 'rgba(54, 162, 235, 0.2)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			},
			{
				label: 'Errors Cost',
				data: $salesWeeklyErrors.slice(-18),
				backgroundColor: 'rgba(220, 53, 69, 0.2)',
				borderColor: 'rgba(220, 53, 69, 1)',
				borderWidth: 1
			}
		]
    },
    options: {
    	scales: {
    		yAxes: [{
    			type: 'linear',
    			position: 'left',
                ticks: {
                    beginAtZero:true
				}
			}]
		},
		elements: {
			line: {
				tension: 0
			}
		}
	}
});



var instEndChart = new Chart(instEndGraph, {
    type: 'line',
    data: {
        labels: $lateEndDate,
        datasets: [
			{
				label: 'Daily Jobs',
				data: $lateEndTot,
				backgroundColor: 'rgba(54, 162, 235, 0.2)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			},
			{
				label: 'Late Finish',
				data: $lateEndLate,
				backgroundColor: 'rgba(235, 162, 54, 0.2)',
				borderColor: 'rgba(235, 162, 54, 1)',
				borderWidth: 1
			}
		]
    },
    options: {
    	scales: {
    		yAxes: [{
    			type: 'linear',
    			position: 'left',
                ticks: {
                    beginAtZero:true
				}
			}]
		},
		elements: {
			line: {
				tension: 0
			}
		}
	}
});




var instStartChart = new Chart(instStartGraph, {
    type: 'bar',
    data: {
        labels: $lateStartDate,
        datasets: [
			{
				label: 'First Stop Jobs',
				data: $lateStartTot,
				yAxisID: 'A',
				backgroundColor: 'rgba(54, 162, 235, 0.2)',
				borderColor: 'rgba(54, 162, 235, 1)',
				borderWidth: 1
			},
			{
				label: 'Late Starts',
				data: $lateStartLate,
				yAxisID: 'A',
				backgroundColor: 'rgba(235, 162, 54, 0.2)',
				borderColor: 'rgba(235, 162, 54, 1)',
				borderWidth: 1
			},
			{
				label: 'Avg. Minutes Late',
				data: $lateStartTime,
				yAxisID: 'B',
				backgroundColor: 'rgba(255, 193, 7, 0.2)',
				borderColor: 'rgba(255, 193, 7, 1)',
				borderWidth: 1,
				type: 'line'
			}
		]
    },
    options: {
    	scales: {
    		yAxes: [{
    			id: 'A',
    			type: 'linear',
    			position: 'left',
                ticks: {
                    beginAtZero:true
                }
    		}, {
    			id: 'B',
    			type: 'linear',
    			position: 'right',
    			ticks: {
                    beginAtZero:false
    			}
    		}]
    	}
    }
});



var installsChart = new Chart(installsGraph, {
    type: 'bar',
    data: {
        labels: $idate,
        datasets: [
			{
				label: 'SqFt',
				data: $sqft,
				yAxisID: 'A',
				backgroundColor: 'rgba(80, 235, 80, 0.2)',
				borderColor: 'rgba(80, 235, 80, 1)',
				borderWidth: 1
			},
			{
				label: 'Jobs',
				data: $jobs,
				yAxisID: 'B',
				backgroundColor: 'rgba(54, 162, 235, 0.2)',
				borderColor: 'rgba(255,99,132,1)',
				borderWidth: 1
			}
		]
    },
    options: {
    	scales: {
    		yAxes: [{
    			id: 'A',
    			type: 'linear',
    			position: 'left',
                ticks: {
                    beginAtZero:true
                }
    		}, {
    			id: 'B',
    			type: 'linear',
    			position: 'right',
    			ticks: {
                    beginAtZero:false
    			}
    		}]
    	}
    }
});

var installsWeekChart = new Chart(installsWeekGraph, {
	type: 'bar',
	data: {
		labels: $weekInstDate.slice(-18),
		datasets: [
			{
				label: 'SqFt',
				data: $weekInstSqft,
				backgroundColor: 'rgba(80, 235, 80, 0.2)',
				borderColor: 'rgba(80, 235, 80, 1)',
				borderWidth: 1
			}
		]
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


var walkinChart = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        datasets: [
			{
            label: 'Walk-Ins',
            data: $walkins,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        },
		{
            label: 'Converted to Sale',
            data: $converted,
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

var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        datasets: [
			{
            label: 'Value Installed',
			yAxisID: 'A',
            data: $installed,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        },
		{
            label: 'Cost of Jobs',
			yAxisID: 'A',
            data: $costs,
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 1
        },
		{
            label: 'Profit',
			yAxisID: 'A',
            data: $profit,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255,99,132,1)',
            borderWidth: 1
        },
		{
            label: 'Profit %',
			yAxisID: 'B',
			type: 'line',
            data: $profitPerc,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255,99,132,1)',
            borderWidth: 1
        }]
    },
    options: {
    	scales: {
    		yAxes: [{
    			id: 'A',
    			type: 'linear',
    			position: 'left',
                ticks: {
                    beginAtZero:true
                }
    		}, {
    			id: 'B',
    			type: 'linear',
    			position: 'right',
    			ticks: {
                    beginAtZero:false
    			}
    		}]
    	}
    }
});
console.log('end');
</script>