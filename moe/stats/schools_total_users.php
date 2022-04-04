<h4>Schools Stats</h4>
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
        var data = google.visualization.arrayToDataTable([
           ['Task', 'Hours per Day'],
          <?php echo $schools_array; ?>
        ]
        );

        var options = {
          title: 'Schools with Number of Users',
          width:'600',
          height:'400'
        };

        var chart = new google.visualization.PieChart(document.getElementById('school_users'));
        chart.draw(data, options);
      }
    </script>

<div id="school_users"></div>
