$(document).ready(function () {

    var hexToRgb = function (hex) {
        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    }

    var randomHexColor = function () {
        return '#' + Math.floor(Math.random() * 16777215).toString(16);
    };

    var stringToColour = function (str) {
        // str to hash
        for (var i = 0, hash = 0; i < str.length; hash = str.charCodeAt(i++) + ((hash << 5) - hash))
            ;

        // int/hash to hex
        for (var i = 0, colour = "#"; i < 3; colour += ("00" + ((hash >> i++ * 8) & 0xFF).toString(16)).slice( - 2))
            ;

        return colour;
    }

    //graphs
    var appColors = $.parseJSON($('#data-app-colors').html());

    Chart.defaults.global.responsive = true;

    var getLabels = function (data) {
        var labels = [];

        $.each(data, function (index, label) {
            labels.push(label);
        });

        return labels;
    };

    var getDatasets = function (applications) {
        var datasets = [];

        $.each(applications, function (application, applicationData) {

            var color = hexToRgb(appColors[application]);

            datasets.push({
                label: application,
                fillColor: "rgba(" + color.r + "," + color.g + "," + color.b + ",0.2)",
                strokeColor: "rgba(" + color.r + "," + color.g + "," + color.b + ",1)",
                pointColor: "rgba(" + color.r + "," + color.g + "," + color.b + ",1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: applicationData
            });

        });

        return datasets;
    };

    //7days
    var data7days = $.parseJSON($('#data-7days').html());
    var applications7days = data7days[1];

    var ctx7days = document.getElementById("canvas-7days").getContext("2d");
    var chart7days = new Chart(ctx7days).Line({
        labels: getLabels(data7days[0]),
        datasets: getDatasets(applications7days)
    }, {
        ///Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,
        //String - Colour of the grid lines
        scaleGridLineColor: "rgba(0,0,0,.05)",
        //Number - Width of the grid lines
        scaleGridLineWidth: 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - Whether the line is curved between points
        bezierCurve: true,
        //Number - Tension of the bezier curve between points
        bezierCurveTension: 0.4,
        //Boolean - Whether to show a dot for each point
        pointDot: true,
        //Number - Radius of each point dot in pixels
        pointDotRadius: 4,
        //Number - Pixel width of point dot stroke
        pointDotStrokeWidth: 1,
        //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
        pointHitDetectionRadius: 20,
        //Boolean - Whether to show a stroke for datasets
        datasetStroke: true,
        //Number - Pixel width of dataset stroke
        datasetStrokeWidth: 2,
        //Boolean - Whether to fill the dataset with a colour
        datasetFill: true,
        //String - A legend template
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
    });

    //exceptions graph
    var exceptionsData = $.parseJSON($('#data-exceptions').html());

    console.log(exceptionsData);

    var getPieDatasets = function (data) {
        var datasets = [];

        $.each(data, function (index, _d) {
//            var color = stringToColour(_d.label);
            var color = randomColor({
                luminosity: 'bright',
                hue: 'orange'
            });

            var o = {
                value: parseInt(_d.value),
                color: color,
                highlight: color,
                label: _d.label
            };

            datasets.push(o);
        });

        return datasets;
    };

    var data = getPieDatasets(exceptionsData);

    var ctxExceptions = document.getElementById("canvas-exceptions").getContext("2d");
    var chartExceptions = new Chart(ctxExceptions).Pie(data, {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke: true,
        //String - The colour of each segment stroke
        segmentStrokeColor: "#fff",
        //Number - The width of each segment stroke
        segmentStrokeWidth: 2,
        //Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 50, // This is 0 for Pie charts
        //Number - Amount of animation steps
        animationSteps: 100,
        //String - Animation easing effect
        animationEasing: "easeOutBounce",
        //Boolean - Whether we animate the rotation of the Doughnut
        animateRotate: true,
        //Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale: false,
        //String - A legend template
        legendTemplate: "<div class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><div><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></div><%}%></div>"
    });

    $('#exceptions-legend').html(chartExceptions.generateLegend());

});