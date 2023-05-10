<?php 
$page_id = null;
$comp_model = new SharedController;
$current_page = $this->set_current_page_link();
?>
<div>
    <div  class="bg-light p-3 mb-3 bg-transparent">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <h4 >The Dashboard (Student)</h4>
                </div>
            </div>
        </div>
    </div>
    <div  class="">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6 comp-grid">
                    <?php $rec_count = $comp_model->getcount_eventrecord();  ?>
                    <a class="animated zoomIn record-count card bg-success text-white"  href="<?php print_link("activity_record/") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-flash fa-3x"></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Event Record</div>
                                    <div class="progress mt-2">
                                        <?php 
                                        $perc = ($rec_count / 100) * 100 ;
                                        ?>
                                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="<?php echo $rec_count; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $perc ?>%">
                                            <span class="progress-label"><?php echo round($perc,2); ?>%</span>
                                        </div>
                                    </div>
                                    <small class="small desc">Display all list of Activity Attendance</small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 comp-grid">
                    <?php $rec_count = $comp_model->getcount_classrecord();  ?>
                    <a class="animated zoomIn record-count card bg-danger text-white"  href="<?php print_link("attendance_record/") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-file-photo-o fa-3x"></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Class Record</div>
                                    <div class="progress mt-2">
                                        <?php 
                                        $perc = ($rec_count / 100) * 100 ;
                                        ?>
                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="<?php echo $rec_count; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $perc ?>%">
                                            <span class="progress-label"><?php echo round($perc,2); ?>%</span>
                                        </div>
                                    </div>
                                    <small class="small desc">Display all list of Subject Attendance</small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div  class="bg-transparent">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-sm-6 comp-grid">
                    <div class="card card-body bg-transparent">
                        <?php 
                        $chartdata = $comp_model->barchart_coursesmoststudentenrolled();
                        ?>
                        <div>
                            <h4>Courses most student Enrolled</h4>
                            <small class="text-muted">Display the statistic for subject most enrolled</small>
                        </div>
                        <hr />
                        <canvas id="barchart_coursesmoststudentenrolled"></canvas>
                        <script>
                            $(function (){
                            var chartData = {
                            labels : <?php echo json_encode($chartdata['labels']); ?>,
                            datasets : [
                            {
                            label: 'Dataset 1',
                            backgroundColor:'rgba(255 , 0 , 255, 0.5)',
                            type:'',
                            borderWidth:3,
                            data : <?php echo json_encode($chartdata['datasets'][0]); ?>,
                            }
                            ]
                            }
                            var ctx = document.getElementById('barchart_coursesmoststudentenrolled');
                            var chart = new Chart(ctx, {
                            type:'bar',
                            data: chartData,
                            options: {
                            scaleStartValue: 0,
                            responsive: true,
                            scales: {
                            xAxes: [{
                            ticks:{display: true},
                            gridLines:{display: true},
                            categoryPercentage: 1.0,
                            barPercentage: 0.8,
                            scaleLabel: {
                            display: true,
                            labelString: "Course(s)"
                            },
                            }],
                            yAxes: [{
                            ticks: {
                            beginAtZero: true,
                            display: true
                            },
                            scaleLabel: {
                            display: true,
                            labelString: "Number of Student"
                            }
                            }]
                            },
                            }
                            ,
                            })});
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
