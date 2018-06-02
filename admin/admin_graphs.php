			<div class="col-12" style="margin-left:0">
                <div id="user-data" class="col-12">
					<div class="row mb-3 pt-3" style="position: sticky; top: 0">
						<h1 class="text-primary col-10">Statistics</h1>
					</div>
					<hr>
					<div class="row">
						<h2>Installs by Day</h2>
						<canvas id="installsGraph" class="col-12"></canvas>
           			</div>
                    <div class="row">
						<h2>Entry</h2>
						<canvas id="entryGraph" class="col-12"></canvas>
           			</div>
                    <div class="row">
						<h2>Install Value</h2>
						<canvas id="incomeGraph" class="col-12"></canvas>
           			</div>
					<hr>
                    <div class="row">
						<h2>Walk-Ins</h2>
						<canvas id="walkinsGraph" class="col-12"></canvas>
           			</div>
				</div>
			</div>

<script>
console.log("start");
var $installed = [];
var $costs = [];
var $profit = [];
var $walkins = [0,0];
var $converted = [0,0];
var $eDate = [];
var $eAnya = [];
var $rAnya = [];
var $eAlex = [];
var $rAlex = [];
var $idate = [];
var $sqft = [];
var $jobs = [];
<?
	$get_entry_stats = new project_action;
	foreach($get_entry_stats->get_entry_stats() as $results) {
		?>
		$eDate.push ('<?= date("m/d/y", strtotime($results['week_beginning'])) ?>');
		$eAnya.push (<?= $results['anya_entered'] ?>);
		$rAnya.push (<?= $results['anya_rejected'] ?>);
		$eAlex.push (<?= $results['alex_entered'] ?>);
		$rAlex.push (<?= $results['alex_rejected'] ?>);
		<?
	}

	$get_sales_stats = new project_action;
	foreach($get_sales_stats->get_sales_stats() as $results) {
		?>
		$installed.push(<?= $results['stat'] ?>);
		$costs.push(<?= $results['cost'] ?>);
		$profit.push(<?= $results['profit'] ?>);

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
var installsGraph = document.getElementById("installsGraph").getContext('2d');
var ctx3 = document.getElementById("entryGraph").getContext('2d');
var ctx2 = document.getElementById("walkinsGraph").getContext('2d');
var ctx = document.getElementById("incomeGraph").getContext('2d');
console.log('middle');
var installsChart = new Chart(installsGraph, {
    type: 'bar',
    data: {
        labels: $idate,
        datasets: [
			{
				label: 'SqFt',
				data: $sqft,
				backgroundColor: [
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)'
				],
				borderColor: [
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)'
				],
				borderWidth: 1
			},
			{
				label: 'Jobs',
				data: $jobs,
				backgroundColor: [
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)'
				],
				borderColor: [
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)'
				],
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

var entryChart = new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: $eDate.slice(-15),
        datasets: [
			{
				label: 'Entered by Anya',
				data: $eAnya.slice(-15),
				backgroundColor: [
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)'
				],
				borderColor: [
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)'
				],
				borderWidth: 1
			},
			{
				label: 'Rejected by Anya',
				data: $rAnya.slice(-15),
				backgroundColor: [
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(54, 162, 235, 0.2)'
				],
				borderColor: [
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)'
				],
				borderWidth: 1
			},
			{
				label: 'Entered by Alex',
				data: $eAlex.slice(-15),
				backgroundColor: [
					'rgba(100, 255, 100, 0.2)',
					'rgba(100, 255, 100, 0.2)',
					'rgba(100, 255, 100, 0.2)',
					'rgba(100, 255, 100, 0.2)',
					'rgba(100, 255, 100, 0.2)',
					'rgba(100, 255, 100, 0.2)',
					'rgba(100, 255, 100, 0.2)',
					'rgba(100, 255, 100, 0.2)',
					'rgba(100, 255, 100, 0.2)',
					'rgba(100, 255, 100, 0.2)',
					'rgba(100, 255, 100, 0.2)',
					'rgba(100, 255, 100, 0.2)',
					'rgba(100, 255, 100, 0.2)',
					'rgba(100, 255, 100, 0.2)',
					'rgba(100, 255, 100, 0.2)',
					'rgba(100, 255, 100, 0.2)',
					'rgba(100, 255, 100, 0.2)'
					
				],
				borderColor: [
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(54, 162, 235, 1)'
				],
				borderWidth: 1
			},
			{
				label: 'Rejected by Alex',
				data: $rAlex.slice(-15),
				backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)'
				],
				borderColor: [
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)',
					'rgba(255,99,132,1)'
				],
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
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 1
        },
		{
            label: 'Converted to Sale',
            data: $converted,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)'
            ],
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
            data: $installed,
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 1
        },
		{
            label: 'Cost of Jobs',
            data: $costs,
            backgroundColor: [
                'rgba(255, 159, 64, 0.2)',
				'rgba(255, 159, 64, 0.2)',
				'rgba(255, 159, 64, 0.2)',
				'rgba(255, 159, 64, 0.2)',
				'rgba(255, 159, 64, 0.2)',
				'rgba(255, 159, 64, 0.2)',
				'rgba(255, 159, 64, 0.2)',
				'rgba(255, 159, 64, 0.2)',
				'rgba(255, 159, 64, 0.2)',
				'rgba(255, 159, 64, 0.2)',
				'rgba(255, 159, 64, 0.2)',
				'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 159, 64, 1)',
				'rgba(255, 159, 64, 1)',
				'rgba(255, 159, 64, 1)',
				'rgba(255, 159, 64, 1)',
				'rgba(255, 159, 64, 1)',
				'rgba(255, 159, 64, 1)',
				'rgba(255, 159, 64, 1)',
				'rgba(255, 159, 64, 1)',
				'rgba(255, 159, 64, 1)',
				'rgba(255, 159, 64, 1)',
				'rgba(255, 159, 64, 1)',
				'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        },
		{
            label: 'Profit',
            data: $profit,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)',
				'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)',
				'rgba(255,99,132,1)'
            ],
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
console.log('end');
</script>