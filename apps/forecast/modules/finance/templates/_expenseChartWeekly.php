

<script type="text/javascript">
            var chart;

//            var chartData = [
//                {
//                    "country": "United States",
//                    "visits": 9252
//                },
//                {
//                    "country": "China",
//                    "visits": 1882
//                },
//                {
//                    "country": "Japan",
//                    "visits": 1809
//                },
//                {
//                    "country": "Germany",
//                    "visits": 1322
//                },
//                {
//                    "country": "United Kingdom",
//                    "visits": 1122
//                },
//                {
//                    "country": "France",
//                    "visits": 1114
//                },
//                {
//                    "country": "India",
//                    "visits": 984
//                },
//                {
//                    "country": "Spain",
//                    "visits": 711
//                }
//            ];


            AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();

                // title of the chart
                chart.addTitle("EXPENSES BREAKDOWN CHART  FOR $1,000 AND UP", 14);

                chart.handDrawn = true;
                chart.dataProvider = <?php echo $chartdata ?>;
                chart.titleField = "particular";
                chart.valueField = "amount";
                chart.sequencedAnimation = true;
                chart.startEffect = "elastic";
                chart.innerRadius = "30%";
                chart.startDuration = 2;
                chart.labelRadius = 15;
                chart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
                // the following two lines makes the chart 3D
                chart.depth3D = 10;
                chart.angle = 15;
                
                // WRITE                                 
                chart.write("expenseChart");
            });
        </script>

<div id="expenseChart" style="width: 1000px; height: 400px;"></div>
