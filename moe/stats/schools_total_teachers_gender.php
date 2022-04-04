
<?php
// retrieve school information from DB
$sql = "SELECT u.gender, count(u.id) as schoolcount from {newwaves_schools} s left join {newwaves_schools_users} u on
                             u.schoolid=s.id where role = 'teacher' group by u.gender";
$reports = $DB->get_records_sql($sql);

//echo var_dump($reports);
//die;



?>
<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = google.visualization.arrayToDataTable(
            [
                ['Task', 'Hours per Day'],

                <?php
                foreach ($reports as $report){
                    echo "[".gender($report->gender).",     ".$report->schoolcount."],";
                }
                ?>
            ]
        );

        var options = {
          title: 'Schools with Number of Students per Gender',
          width:'600',
          height:'400'
        };

        var chart = new google.visualization.PieChart(document.getElementById('school_teachers_gender'));
        chart.draw(data, options);
      }
    </script>

<div id="school_teachers_gender"></div>
