<?php
// This file is part of Moodle Integrator Plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     School Dashboard
 * @author      Kristian
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

// retrieve school information from DB
$sql = "SELECT type, count(id) as schoolcount from {newwaves_schools} group by type";
$reports = $DB->get_records_sql($sql);
//var_dump($schools);
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
                      echo "['".convertType($report->type)."',     ".$report->schoolcount."],";
                  }
              ?>
        ]
        );

        var options = {
          title: 'School Types',
          width:'600',
          height:'400'
        };

        var chart = new google.visualization.PieChart(document.getElementById('school_types'));
        chart.draw(data, options);
      }
    </script>

<div id="school_types"></div>
