/*
Template Name: RichTv -  Admin & Dashboard
Author: Abdul
Contact: abservicesground@gmail.com
File: Dashboard Init Js File
*/

document.addEventListener('DOMContentLoaded', function () {
    // User Growth Chart (Line Chart)
    var userGrowthOptions = {
        chart: {
            type: 'line',
            height: 350,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        series: [{
            name: 'New Users',
            data: @json($userGrowth->pluck('count'))
        }],
        xaxis: {
            categories: @json($userGrowth->pluck('month')->map(function($m) {
                return \Carbon\Carbon::create()->month($m)->format('M');
            })),
            title: {
                text: 'Month'
            }
        },
        yaxis: {
            title: {
                text: 'Number of Users'
            }
        },
        colors: ['#edb043'],
        stroke: {
            curve: 'smooth',
            width: 3
        },
        dataLabels: {
            enabled: false
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val;
                }
            }
        }
    };

    var userGrowthChart = new ApexCharts(document.querySelector("#user-growth-chart"), userGrowthOptions);
    userGrowthChart.render();

    // Exam Metrics Donut Chart
    var examMetricsOptions = {
        series: [
            @json($totalExams),
            @json($activeExams),
            @json($totalQuestions)
        ],
        labels: ["Total Exams", "Active Exams", "Total Questions"],
        chart: {
            type: 'donut',
            height: 350,
        },
        plotOptions: {
            pie: {
                size: '80%',
                donut: {
                    size: '60%',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '16px',
                            color: '#343a40',
                            offsetY: -10
                        },
                        value: {
                            show: true,
                            fontSize: '20px',
                            color: '#343a40',
                            formatter: function (val) {
                                return val;
                            }
                        },
                        total: {
                            show: false,
                        }
                    }
                }
            }
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            position: 'bottom',
            labels: {
                colors: '#343a40',
            }
        },
        colors: ['#edb043', '#0c768a', '#38c786'],
        tooltip: {
            y: {
                formatter: function (val) {
                    return val;
                }
            }
        }
    };

    var examMetricsDonut = new ApexCharts(document.querySelector("#exam-metrics-donut"), examMetricsOptions);
    examMetricsDonut.render();

    // Live Users By Zip (jsVectorMap)
    var zipData = {
        @foreach($liveUsersByZip as $zip)
            "{{ $zip->zip }}": {{ $zip->count }},
        @endforeach
    };

    // Assuming you have a helper function to convert zip codes to coordinates.
    // You need to provide latitude and longitude for each zip code.
    // Here's an example structure:
    var zipCoordinates = {
        "10001": [40.7128, -74.0060],
        "90001": [34.0522, -118.2437],
    };

    // For demonstration, let's assume zipCoordinates is available
    var zipCoordinates = {
        @foreach($liveUsersByZip as $zip)
            "{{ $zip->zip }}": [{{ $zip->latitude }}, {{ $zip->longitude }}],
        @endforeach
    };

    var zipMapMarkers = [];
    for (var zip in zipData) {
        if (zipCoordinates[zip]) {
            zipMapMarkers.push({
                name: `Zip: ${zip}`,
                coords: zipCoordinates[zip],
                style: {
                    fill: '#edb043',
                    stroke: '#ffffff',
                    'stroke-width': 1
                },
                label: `${zip}: ${zipData[zip]} Users`
            });
        }
    }

    new jsVectorMap({
        map: "world_merc",
        selector: "#zip-map-markers",
        zoomOnScroll: false,
        zoomButtons: false,
        markerStyle:{
            initial: { 
                fill: "#edb043",
                stroke: "#ffffff",
                'stroke-width': 1
            },
            selected: { 
                fill: "#edb043",
                stroke: "#ffffff",
                'stroke-width': 1
            }
        },
        markers: zipMapMarkers,
        regionStyle: {
            initial: {
                fill: "#daeaee",
                stroke: "#ffffff",
                "stroke-width": 0.25,
                fillOpacity: 1,
            },
        },
        tooltip: {
            enabled: true,
            format: function (marker) {
                return marker.label;
            }
        }
    });

    // Active Watchlists Over Time (Area Chart)
    var activeWatchlistsOptions = {
        chart: {
            type: 'area',
            height: 350,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        series: [{
            name: 'Active Watchlists',
            data: @json($watchlistGrowth->pluck('count'))
        }],
        xaxis: {
            categories: @json($watchlistGrowth->pluck('month')->map(function($m) {
                return \Carbon\Carbon::create()->month($m)->format('M');
            })),
            title: {
                text: 'Month'
            }
        },
        yaxis: {
            title: {
                text: 'Number of Watchlists'
            }
        },
        colors: ['#edb043'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 100]
            }
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        dataLabels: {
            enabled: false
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val;
                }
            }
        }
    };

    var activeWatchlistsChart = new ApexCharts(document.querySelector("#active-watchlists-chart"), activeWatchlistsOptions);
    activeWatchlistsChart.render();
});
