
<?php
// retrieve school information from DB
$sql = "SELECT s.name, count(u.id) as schoolcount from {newwaves_schools} s left join {newwaves_schools_users} u on
                             u.schoolid=s.id where role = 'schooladmin' group by s.name";
$schools = $DB->get_records_sql($sql);
// var_dump($schools);
//die;


$chart_data = array();

$schools_array = array();
array_push($schools_array, 'School', 'Count');
array_push($chart_data, $schools_array);

foreach($schools as $row){
    $schools_array = array();
    array_push($schools_array, $row->name, intval($row->schoolcount));
    array_push($chart_data, $schools_array);
}

$chart_data = json_encode($chart_data);
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
            <?php echo $chart_data; ?>
        );

        var options = {
          title: 'Schools with Number of Schooladmin',
          width:'600',
          height:'400'
        };

        var chart = new google.visualization.PieChart(document.getElementById('school_schooladmin'));
        chart.draw(data, options);
      }
    </script>

<div id="school_schooladmin"></div>
