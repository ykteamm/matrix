@extends('admin.layouts.app')
@section('admin_content')
<div class="content mt-1 main-wrapper">
   <div class="row gold-box">
      @include('admin.components.logo')
      <div class="card flex-fill">

     </div>
   </div>


<div class="content headbot">
    <div class="row">
       <div class="col-12 col-xl-12 d-flex flex-wrap">
          <div class="card">
             <div class="card-body">
{{--               @foreach ($regions as $item)--}}
               <div class="row">
{{--                  {{$item->name}}--}}
               </div>
               <div class="row" id="kamola">

               </div>
{{--               @endforeach--}}
             </div>
          </div>
       </div>

        <div class="col-12 col-xl-12 d-flex flex-wrap">
            <div class="card">
                <div class="card-body">
                    {{--               @foreach ($regions as $item)--}}
                    <div class="row">
                        {{--                  {{$item->name}}--}}
                    </div>
                    <div class="row" id="gulzar">

                    </div>
                    {{--               @endforeach--}}
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-12 d-flex flex-wrap">
            <div class="card">
                <div class="card-body">
                    {{--               @foreach ($regions as $item)--}}
                    <div class="row">
                        {{--                  {{$item->name}}--}}
                    </div>
                    <div class="row" id="nilufar">

                    </div>
                    {{--               @endforeach--}}
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-12 d-flex flex-wrap">
            <div class="card">
                <div class="card-body">
                    {{--               @foreach ($regions as $item)--}}
                    <div class="row">
                        {{--                  {{$item->name}}--}}
                    </div>
                    <div class="row" id="shahnoza">

                    </div>
                    {{--               @endforeach--}}
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-12 d-flex flex-wrap">
            <div class="card">
                <div class="card-body">
                    {{--               @foreach ($regions as $item)--}}
                    <div class="row">
                        {{--                  {{$item->name}}--}}
                    </div>
                    <div class="row" id="gozal">

                    </div>
                    {{--               @endforeach--}}
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
@section('admin_script')
{{--    Kamola--}}
      <script >
            {{--var json = <?php echo json_encode( $json ) ?>;--}}
            {{--var date_array = <?php echo json_encode( $date_array ) ?>;--}}
            // $.each(json, function(index, value){

            var date_array = ["Yanvar", "Fevral", "Mart", "Aprel", "May", "Iyun","Iyul", "Avgust","Sentyabr", "Oktyabr", "Noyabr","Dekabr"]
                var options = {
                    series: [ {
                        name: 'Oylik Sotuv',
                        // type: 'line',
                        data: [36, 41, 53, 29.8, 30, 35, 39.8, 62, 19.8, 25, 33, 38]
                    }, {
                        name: 'Oylik Maosh',
                        // type: 'line',
                        data: [4.2, 3.9, 4.5, 3.9, 3.2, 4.7, 4.9, 5, 4, 3, 5, 6]
                    }],
                    chart: {
                        height: 350,
                        type: 'area',
                        // stacked: false
                    },
                    colors:['#008FFB', '#d92452'],
                    fill: {
                        colors: ['#008FFB', '#d92452']
                    },
                    dataLabels: {
                        // enabled: false
                        style: {
                            colors: ['#008FFB', '#d92452',]
                        }
                    },
                    stroke: {
                        // width: [4, 4]
                        curve: 'smooth'
                    },
                    title: {
                        text: 'Kamola',
                        align: 'left',
                        offsetX: 110
                    },
                    xaxis: {
                        categories: date_array
                    },
                    yaxis: [
                        {
                            axisTicks: {
                                show: true,
                            },
                            axisBorder: {
                                show: true,
                                color: '#008FFB'
                            },
                            labels: {
                                style: {
                                    colors: '#008FFB',
                                }
                            },
                            title: {
                                text: "Oylik sotuvi",
                                style: {
                                    color: '#008FFB',
                                }
                            },
                            tooltip: {
                                enabled: true
                            }
                        },
                        {
                            seriesName: 'Oylik',
                            opposite: true,
                            axisTicks: {
                                show: true,
                            },
                            axisBorder: {
                                show: true,
                                color: '#d92452'
                            },
                            labels: {
                                style: {
                                    colors: '#d92452',
                                }
                            },
                            title: {
                                text: "Oylik maosh",
                                style: {
                                    color: '#d92452',
                                }
                            },
                        },
                    ],
                    tooltip: {
                        fixed: {
                            enabled: true,
                            position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                            offsetY: 30,
                            offsetX: 60
                        },
                    },
                    legend: {
                        horizontalAlign: 'left',
                        offsetX: 40
                    }
                };

                var chart = new ApexCharts(document.querySelector("#kamola"), options);
                chart.render();
            // });

      </script>
{{--Gulzar--}}
      <script>
          {{--var json = <?php echo json_encode( $json ) ?>;--}}
          {{--var date_array = <?php echo json_encode( $date_array ) ?>;--}}
          // $.each(json, function(index, value){

          var date_array = ["Yanvar", "Fevral", "Mart", "Aprel", "May", "Iyun","Iyul", "Avgust","Sentyabr", "Oktyabr", "Noyabr","Dekabr"]
          var options = {
              series: [ {
                  name: 'Oylik Sotuv',
                  // type: 'line',
                  data: [6, 12.3, 18.2, 9.5, 17.3, 20.3, 16.5, 15.5, 15, 16.3, 16, 21.3],
                  // color: '#008FFB'
              }, {
                  name: 'Oylik Maosh',
                  // type: 'line',
                  data: [1.5, 2.2, 2.3, 2, 1.7, 2.4, 2.4, 1.9, 4, 3, 3, 6],
                  // color:'#d92452'
              }],
              chart: {
                  height: 350,
                  type: 'area',
                  // stacked: false
              },
              colors:['#008FFB', '#d92452'],
              fill: {
                  colors: ['#008FFB', '#d92452']
              },
              dataLabels: {
                  // enabled: false
                  style: {
                      colors: ['#008FFB', '#d92452',]
                  }
              },
              stroke: {
                  // width: [4, 4]
                  curve: 'smooth'
              },
              title: {
                  text: 'Gulzar',
                  align: 'left',
                  offsetX: 110
              },
              xaxis: {
                  categories: date_array
              },
              yaxis: [
                  {
                      axisTicks: {
                          show: true,
                      },
                      axisBorder: {
                          show: true,
                          color: '#008FFB'
                      },
                      labels: {
                          style: {
                              colors: '#008FFB',
                          }
                      },
                      title: {
                          text: "Oylik sotuvi",
                          style: {
                              color: '#008FFB',
                          }
                      },
                      tooltip: {
                          enabled: true
                      }
                  },
                  {
                      // seriesName: 'Oylik',
                      opposite: true,
                      axisTicks: {
                          show: true,
                      },
                      axisBorder: {
                          show: true,
                          color: '#d92452'
                      },
                      labels: {
                          style: {
                              colors: '#d92452',
                          }
                      },
                      title: {
                          text: "Oylik maosh",
                          style: {
                              color: '#d92452',
                          }
                      },
                  },
              ],
              tooltip: {
                  fixed: {
                      enabled: true,
                      position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                      offsetY: 30,
                      offsetX: 60
                  },
              },
              legend: {
                  horizontalAlign: 'left',
                  offsetX: 40
              }
          };

          var chart = new ApexCharts(document.querySelector("#gulzar"), options);
          chart.render();
          // });

      </script>
{{--    Nilufar--}}
<script>
    {{--var json = <?php echo json_encode( $json ) ?>;--}}
    {{--var date_array = <?php echo json_encode( $date_array ) ?>;--}}
    // $.each(json, function(index, value){

    var date_array = ["Yanvar", "Fevral", "Mart", "Aprel", "May", "Iyun","Iyul", "Avgust","Sentyabr", "Oktyabr", "Noyabr","Dekabr"]
    var options = {
        series: [ {
            name: 'Oylik Sotuv',
            // type: 'are',
            data: [25, 28, 31, 17.6, 25.5, 32.4, 25, 33, 28.2, 30, 16.8, 18.2]
        }, {
            name: 'Oylik Maosh',
            // type: 'area',
            data: [3.1, 3.8, 4.3, 3, 3.2, 4.2, 3.3, 4.3, 4, 5, 5, 3]
        }],
        chart: {
            height: 350,
            type: 'area',
            stacked: false
        },
        colors:['#008FFB', '#d92452'],
        fill: {
            colors: ['#008FFB', '#d92452']
        },
        dataLabels: {
            // enabled: false
            style: {
                colors: ['#008FFB', '#d92452',]
            }
        },
        stroke: {
            // width: [4, 4]
            curve: 'smooth'
        },
        title: {
            text: 'Nilufar',
            align: 'left',
            offsetX: 110
        },
        xaxis: {
            categories: date_array
        },
        yaxis: [
            {
                axisTicks: {
                    show: true,
                },
                axisBorder: {
                    show: true,
                    color: '#008FFB'
                },
                labels: {
                    style: {
                        colors: '#008FFB',
                    }
                },
                title: {
                    text: "Oylik sotuvi",
                    style: {
                        color: '#008FFB',
                    }
                },
                tooltip: {
                    enabled: true
                }
            },
            {
                seriesName: 'Oylik',
                opposite: true,
                axisTicks: {
                    show: true,
                },
                axisBorder: {
                    show: true,
                    color: '#d92452'
                },
                labels: {
                    style: {
                        colors: '#d92452',
                    }
                },
                title: {
                    text: "Oylik maosh",
                    style: {
                        color: '#d92452',
                    }
                },
            },
        ],
        tooltip: {
            fixed: {
                enabled: true,
                position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                offsetY: 30,
                offsetX: 60
            },
        },
        legend: {
            horizontalAlign: 'left',
            offsetX: 40
        }
    };

    var chart = new ApexCharts(document.querySelector("#nilufar"), options);
    chart.render();
    // });

</script>
{{--    Shahnoza--}}
<script>
    {{--var json = <?php echo json_encode( $json ) ?>;--}}
    {{--var date_array = <?php echo json_encode( $date_array ) ?>;--}}
    // $.each(json, function(index, value){

    var date_array = ["Yanvar", "Fevral", "Mart", "Aprel", "May", "Iyun","Iyul", "Avgust","Sentyabr", "Oktyabr", "Noyabr","Dekabr"]
    var options = {
        series: [ {
            name: 'Oylik Sotuv',
            // type: 'line',
            data: [0, 0, 1.8, 10.7, 16.5, 17, 21.7, 23.4, 16.4, 13.8, 34.7, 44.3]
        }, {
            name: 'Oylik Maosh',
            // type: 'line',
            data: [0, 1.7, 2.1, 3, 1.9, 2, 2.6, 2.8, 4, 3, 5, 6]
        }],
        chart: {
            height: 350,
            type: 'area',
            // stacked: false
        },
        colors:['#008FFB', '#d92452'],
        fill: {
            colors: ['#008FFB', '#d92452']
        },
        dataLabels: {
            // enabled: false
            style: {
                colors: ['#008FFB', '#d92452',]
            }
        },
        stroke: {
            // width: [4, 4]
            curve: 'smooth'
        },
        title: {
            text: 'Shahnoza',
            align: 'left',
            offsetX: 110
        },
        xaxis: {
            categories: date_array
        },
        yaxis: [
            {
                axisTicks: {
                    show: true,
                },
                axisBorder: {
                    show: true,
                    color: '#008FFB'
                },
                labels: {
                    style: {
                        colors: '#008FFB',
                    }
                },
                title: {
                    text: "Oylik sotuvi",
                    style: {
                        color: '#008FFB',
                    }
                },
                tooltip: {
                    enabled: true
                }
            },
            {
                seriesName: 'Oylik',
                opposite: true,
                axisTicks: {
                    show: true,
                },
                axisBorder: {
                    show: true,
                    color: '#d92452'
                },
                labels: {
                    style: {
                        colors: '#d92452',
                    }
                },
                title: {
                    text: "Oylik maosh",
                    style: {
                        color: '#d92452',
                    }
                },
            },
        ],
        tooltip: {
            fixed: {
                enabled: true,
                position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                offsetY: 30,
                offsetX: 60
            },
        },
        legend: {
            horizontalAlign: 'left',
            offsetX: 40
        }
    };

    var chart = new ApexCharts(document.querySelector("#shahnoza"), options);
    chart.render();
    // });

</script>
{{--    Gozal--}}
<script >
    {{--var json = <?php echo json_encode( $json ) ?>;--}}
    {{--var date_array = <?php echo json_encode( $date_array ) ?>;--}}
    // $.each(json, function(index, value){

    var date_array = ["Yanvar", "Fevral", "Mart", "Aprel", "May", "Iyun","Iyul", "Avgust","Sentyabr", "Oktyabr", "Noyabr","Dekabr"]
    var options = {
        series: [ {
            name: 'Oylik Sotuv',
            // type: 'line',
            data: [0, 0, 0, 0, 0, 0, 0, 0, 10.3, 14, 16.5, 13.9]
        }, {
            name: 'Oylik Maosh',
            // type: 'line',
            data: [0, 0, 0, 0, 0, 0, 0, 0, 4, 3, 3, 3]
        }],
        chart: {
            height: 350,
            type: 'area',
            // stacked: false
        },
        colors:['#008FFB', '#d92452'],
        fill: {
            colors: ['#008FFB', '#d92452']
        },
        dataLabels: {
            // enabled: false
            style: {
                colors: ['#008FFB', '#d92452',]
            }
        },
        stroke: {
            // width: [4, 4]
            curve: 'smooth'
        },
        title: {
            text: 'Gozal',
            align: 'left',
            offsetX: 110
        },
        xaxis: {
            categories: date_array
        },
        yaxis: [
            {
                axisTicks: {
                    show: true,
                },
                axisBorder: {
                    show: true,
                    color: '#008FFB'
                },
                labels: {
                    style: {
                        colors: '#008FFB',
                    }
                },
                title: {
                    text: "Oylik sotuvi",
                    style: {
                        color: '#008FFB',
                    }
                },
                tooltip: {
                    enabled: true
                }
            },
            {
                seriesName: 'Oylik',
                opposite: true,
                axisTicks: {
                    show: true,
                },
                axisBorder: {
                    show: true,
                    color: '#d92452'
                },
                labels: {
                    style: {
                        colors: '#d92452',
                    }
                },
                title: {
                    text: "Oylik maosh",
                    style: {
                        color: '#d92452',
                    }
                },
            },
        ],
        tooltip: {
            fixed: {
                enabled: true,
                position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                offsetY: 30,
                offsetX: 60
            },
        },
        legend: {
            horizontalAlign: 'left',
            offsetX: 40
        }
    };

    var chart = new ApexCharts(document.querySelector("#gozal"), options);
    chart.render();
    // });

</script>
@endsection
