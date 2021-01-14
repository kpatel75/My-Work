@extends('layouts.app')


@section('content')

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- COUNRTY -->
    <!-- First country level bar graph -->
    <script type="text/javascript">
        var membersByProvinceCountry = <?php echo $membersByProvinceCountry; ?>;
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable(
                membersByProvinceCountry);

            var options = {
                title: 'Members by Jurisdiction',
                legend: { position: 'bottom'},
                backgroundColor: '#F8FAFC',
                isStacked: true,
                colors: ['#B63226'],
                fontSize: 12,
                width: 800,
                height: 300,
                bar: {
                    groupWidth: "85%"
                },
                chartArea: {
                    width: '92%'
                },
                titleTextStyle: {
                    fontSize: 15
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('countryColumnChart'));

            chart.draw(data, options);
        }
    </script>
    <!-- Second country level pie chart -->
    <script type="text/javascript">
        var membersByAgeCountry = <?php echo $membersByAgeCountry; ?>;
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable(
                membersByAgeCountry);

            var options = {
                title: 'Members by Age (Country Wide)',
                pieHole: 0.4,
                backgroundColor: '#F8FAFC',
                chartArea: {
                    width: '100%',
                    hieght: '80%'
                },
                width: 370,
                height: 300,
                titleTextStyle: {
                    fontSize: 15
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('countryPiechart'));

            chart.draw(data, options);
        }
    </script>

    <!-- Jurisdiction -->
    <!-- First jurisdiction level bar graph -->
    <script type="text/javascript">
        var memberByChapterJurisdiction = <?php echo $memberByChapterJurisdiction; ?>;
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable(
                memberByChapterJurisdiction);

            var options = {
                title: 'Members by Chapter',
                legend: { position: 'bottom'},
                backgroundColor: '#F8FAFC',
                colors: ['#F6CD25'],
                width: 800,
                height: 300,
                bar: {
                    groupWidth: "85%"
                },
                chartArea: {
                    width: '92%'
                },
                titleTextStyle: {
                    fontSize: 15
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('jurisdictionColumnChart'));

            chart.draw(data, options);
        }
    </script>
    <!-- Second jurisdictionn level pie chart -->
    <script type="text/javascript">
        var membersByAgeJurisdiction = <?php echo $membersByAgeJurisdiction; ?>;
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable(
                membersByAgeJurisdiction);

            var options = {
                title: 'Members by Age (Jurisdiction Wide)',
                pieHole: 0.4,
                backgroundColor: '#F8FAFC',
                chartArea: {
                    width: '100%',
                    hieght: '80%'
                },
                width: 370,
                height: 300,
                titleTextStyle: {
                    fontSize: 15
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('jurisdictionPiechart'));

            chart.draw(data, options);
        }
    </script>
    <!-- CHAPTER -->
    <!-- first chapter level pie chart -->
    <script type="text/javascript">
        var membersByAgeChapter = <?php echo $membersByAgeChapter; ?>;
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable(
                membersByAgeChapter);

            var options = {
                title: 'Members by Age (Chapter Wide)',
                pieHole: 0.4,
                backgroundColor: '#F8FAFC',
                chartArea: {
                    width: '100%',
                    hieght: '100%'
                },
                titleTextStyle: {
                    fontSize: 15
                },
                height: 400,
                width: 600
            };

            var chart = new google.visualization.PieChart(document.getElementById('chapterPiechart'));

            chart.draw(data, options);
        }
    </script>
</head>

<div class="container">
    <div class="row justify-center">
        <div>
            @guest
            <h1>Welcome, please login</h1>
            @else
            <h1>Welcome, {{ Auth::user()->first_name }}</h1>
            @endguest 
            @ITAdmin('member', 'read')
            <a href="{{ route('agedistributionreport') }}" class="btn btn-success">Age Distriburion Report</a>
            <a href="{{ route('activitydistributionreport') }}" class="btn btn-success">Activity Distribution Report</a>
            <a href="{{ route('memberlistreport') }}" class="btn btn-success">Members List Report</a> 
            @endITAdmin
        </div>
    </div>
    <br /><br /> 
    @ITAdmin('country', 'read')
    <!-- Country Level Row -->
    <div class="row">
        @if($membersByAgeCountry == "[[\"Age\",\"Members\"]]")
            <h2 style="padding-left: 30px;">No dashboard data</h2>
        @else
        <div class="justify-center">
            <h2>Country Overview</h2>
        </div>
        <div class="row">
            <div id="countryColumnChart"></div>
            <div id="countryPiechart"></div>
        </div>
    </div> 
    @endITAdmin
    <br /><br />
    @ITAdmin('jurisdiction', 'read')
    @if(Auth::user()->jurisdiction_id == 0)
    @else
    <!-- jurisdiction Level Row -->
        <div class="row">
        @if($membersByAgeJurisdiction == "[[\"Age\",\"Members\"]]")
            <h2 style="padding-left: 30px;">No Jurisdiction data</h2>
        @else
            <div class="justify-center">
                <h2>Jurisdiction Overview</h2>
            </div>
            <div class="row">
                <div id="jurisdictionColumnChart"></div>
                <div id="jurisdictionPiechart"></div>
            </div>
        </div> 
    @endITAdmin
        <br /><br />
    @if(Auth::user()->chapter_id == null)
    @else
        <!-- Chapter Level Row -->
        <div class="row">
        @if($membersByAgeChapter == "[[\"Age\",\"Members\"]]")
            <h2 style="padding-left: 30px;">No Chapter data</h2>
        @else
            <div class="justify-center">
                <h2>Chapter Overview</h2>
            </div>
        </div>
        <div class="row mx-auto d-block">
            <div class="col-4 mx-auto">
                <div id="chapterPiechart"></div>
            </div>
        </div>
    @endif
    @endif
    @endif
    @endif
    @endif
</div>
@endsection