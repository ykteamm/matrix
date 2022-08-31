function dateChart(a_text){
    // var tab_active = $("#solid-rounded-tab1").attr('title');
    var text = $(`#${a_text}`).text();
    $("#age_button").text(text);
    $("#age_button").val(a_text);
    var check_but = $("#chec_select").val();
    // console.log(check_but);
    var date = a_text;
    var pol = $("#pol_name").text();
    var tab_array = ['all_count','pol_count','age_count','come_count','dia_count','ill_count'];
    var _token   = $('meta[name="csrf-token"]').attr('content');
    $.each(tab_array, function( index, value ) {
      var tab_active = value;

    if (tab_active == 'all_count') {
    $.ajax({
      url: "/stat/date",
      type:"POST",
      data:{
        date: date,
        check: check_but,
        tab: tab_active,
        _token: _token
      },
      success:function(response){
        if(response) {
          $('#all_count').remove();
          // $('#pol_count').remove();
          // $('#age_count').remove();
          // $('#come_count').remove();
          // $('#dia_count').remove();
          // $('#ill_count').remove();
          $('#solid-rounded-tab1').after("<div id='all_count'></div>");
          var all_count = response.all_count;
          var date_array = response.date_array;

          var options = {
            series: [{
              name: 'all_count',
              data: all_count
            }],
            chart: {
              height: 350,
              type: 'area'
            },
            dataLabels: {
              enabled: false
            },
            stroke: {
              curve: 'smooth'
            },
            xaxis: {
              type: 'date',
              categories: date_array
            },
            tooltip: {
              x: {
                format: 'dd/MM/yy'
              },
            },
          };
          var chart = new ApexCharts(document.querySelector("#all_count"), options);
          chart.render();
            
        }
      },
      error: function(error) {
       console.log(error);
      }
     });
    }
    if (tab_active == 'pol_count') {
      $.ajax({
        url: "/stat/date",
        type:"POST",
        data:{
          date: date,
          check: check_but,
          tab: tab_active,
          _token: _token
        },
        success:function(response){
          if(response) {
            // $('#all_count').remove();
            $('#pol_count').remove();
            // $('#age_count').remove();
            // $('#come_count').remove();
            // $('#dia_count').remove();
            // $('#ill_count').remove();
            $('#solid-rounded-tab2').after("<div id='pol_count'></div>");
            var male_count = response.male_count;
            var female_count = response.female_count;
            var date_array = response.date_array;
            var check = response.check;
            var lebel = response.lebel;
            var check_array = response.check_array;
            if (lebel) {
              var options = {
                series: [{
                  name: lebel,
                  data: check
                }],
                chart: {
                  height: 350,
                  type: 'area'
                },
                dataLabels: {
                  enabled: false
                },
                stroke: {
                  curve: 'smooth'
                },
                title: {
                  name: lebel,
                  align: 'top'
                },
                xaxis: {
                  type: 'date',
                  categories: date_array
                },
                tooltip: {
                  x: {
                    format: 'dd/MM/yy'
                  },
                },
              };
            } else {
              var options = {
                series: [{
                  name: 'male',
                  data: male_count
                },{
                  name: 'female',
                  data: female_count
                }],
                chart: {
                  height: 350,
                  type: 'area'
                },
                dataLabels: {
                  enabled: false
                },
                stroke: {
                  curve: 'smooth'
                },
                xaxis: {
                  type: 'date',
                  categories: date_array
                },
                tooltip: {
                  x: {
                    format: 'dd/MM/yy'
                  },
                },
              };
            }
  
            
            
            var chart = new ApexCharts(document.querySelector("#pol_count"), options);
            chart.render();
              
          }
        },
        error: function(error) {
         console.log(error);
        }
       });
      }
    if (tab_active == 'age_count') {
      $.ajax({
        url: "/stat/date",
        type:"POST",
        data:{
          date: date,
          check: check_but,
          tab: tab_active,
          _token: _token
        },
        success:function(response){
          
          if(response) {
            // $('#all_count').remove();
            // $('#pol_count').remove();
            $('#age_count').remove();
            // $('#come_count').remove();
            // $('#dia_count').remove();
            // $('#ill_count').remove();
                $('#solid-rounded-tab3').after("<div id='age_count'></div>");
            var age_29 = response.age_29;
            var age_30 = response.age_30;
            var age_46 = response.age_46;
            var age_56 = response.age_56;
            var age_66 = response.age_66;
            var age_76 = response.age_76;
            var check_count = response.check_count;
            var date_array = response.date_array;
            var lebel = response.lebel;
      console.log(date_array);

          if (check_count) {
            var options = {
              series: [{
                name: 'ddd',
                data: check_count
              }],
              chart: {
                height: 350,
                type: 'area'
              },
              dataLabels: {
                enabled: false
              },
              stroke: {
                curve: 'smooth'
              },
              xaxis: {
                type: 'date',
                categories: date_array
              },
              tooltip: {
                x: {
                  format: 'dd/MM/yy'
                },
              },
            };
          } else {
            var options = {
              series: [{
                name: '-29',
                data: age_29
              },{
                name: '32 - 45',
                data: age_30
              },{
                name: '46 - 55',
                data: age_46
              },{
                name: '56 - 65',
                data: age_56
              },{
                name: '66 - 75',
                data: age_66
              },{
                name: '76-',
                data: age_76
              }],
              chart: {
                height: 350,
                type: 'area'
              },
              dataLabels: {
                enabled: false
              },
              stroke: {
                curve: 'smooth'
              },
              xaxis: {
                type: 'date',
                categories: date_array
              },
              tooltip: {
                x: {
                  format: 'dd/MM/yy'
                },
              },
            };
          }


            var chart = new ApexCharts(document.querySelector("#age_count"), options);
            chart.render();

          }
        },
        error: function(error) {
         console.log(error);
        }
      });
    }
     
        if (tab_active == 'come_count') {
          $.ajax({
            url: "/stat/date",
            type:"POST",
            data:{
              date: date,
              check: check_but,
              tab: tab_active,
              _token: _token
            },
            success:function(response){
              if(response) {
                // $('#all_count').remove();
                // $('#pol_count').remove();
                // $('#age_count').remove();
                $('#come_count').remove();
                // $('#dia_count').remove();
                // $('#ill_count').remove();
                $('#solid-rounded-tab4').after("<div id='come_count'></div>");
                var skori_count = response.skori_count;
                var net_skori_count = response.net_skori_count;
                var date_array = response.date_array;
                var check_count = response.check_count;
                var lebel = response.lebel;
                if (check_count) {
                  var options = {
                    series: [{
                      name: 'lebel',
                      data: check_count
                    }],
                    chart: {
                      height: 350,
                      type: 'area'
                    },
                    dataLabels: {
                      enabled: false
                    },
                    stroke: {
                      curve: 'smooth'
                    },
                    title: {
                      name: lebel,
                      align: 'top'
                    },
                    xaxis: {
                      type: 'date',
                      categories: date_array
                    },
                    tooltip: {
                      x: {
                        format: 'dd/MM/yy'
                      },
                    },
                  };
                } else {
                  var options = {
                    series: [{
                      name: 'Скорой',
                      data: skori_count
                    },{
                      name: 'Самотек',
                      data: net_skori_count
                    }],
                    chart: {
                      height: 350,
                      type: 'area'
                    },
                    dataLabels: {
                      enabled: false
                    },
                    stroke: {
                      curve: 'smooth'
                    },
                    xaxis: {
                      type: 'date',
                      categories: date_array
                    },
                    tooltip: {
                      x: {
                        format: 'dd/MM/yy'
                      },
                    },
                  };
                }
                
                
                var chart = new ApexCharts(document.querySelector("#come_count"), options);
                chart.render();
                  
              }
            },
            error: function(error) {
             console.log(error);
            }
           });
          }
    if (tab_active == 'dia_count') {
          $.ajax({
            url: "/stat/date",
            type:"POST",
            data:{
              date: date,
              check: check_but,
              tab: tab_active,
              _token: _token
            },
            success:function(response){
              if(response) {
                // $('#all_count').remove();
                // $('#pol_count').remove();
                // $('#age_count').remove();
                // $('#come_count').remove();
                $('#dia_count').remove();
                // $('#ill_count').remove();
                    $('#solid-rounded-tab5').after("<div id='dia_count'></div>");
                var ag_count = response.ag_count;
                var tip_count = response.tip_count;
                var oji_count = response.oji_count;
                var giper_count = response.giper_count;
                var check_count = response.check_count;
                var date_array = response.date_array;
                if (check_count) {
                  var options = {
                    series: [{
                      name: 'oji_count',
                      data: check_count
                    }],
                    chart: {
                      height: 350,
                      type: 'area'
                    },
                    dataLabels: {
                      enabled: false
                    },
                    stroke: {
                      curve: 'smooth'
                    },
                    xaxis: {
                      type: 'date',
                      categories: date_array
                    },
                    tooltip: {
                      x: {
                        format: 'dd/MM/yy'
                      },
                    },
                  };
                } else {
                  var options = {
                    series: [{
                      name: 'ag_count',
                      data: ag_count
                    },{
                      name: 'tip_count',
                      data: tip_count
                    },{
                      name: 'oji_count',
                      data: oji_count
                    },{
                      name: 'giper_count',
                      data: giper_count
                    }],
                    chart: {
                      height: 350,
                      type: 'area'
                    },
                    dataLabels: {
                      enabled: false
                    },
                    stroke: {
                      curve: 'smooth'
                    },
                    xaxis: {
                      type: 'date',
                      categories: date_array
                    },
                    tooltip: {
                      x: {
                        format: 'dd/MM/yy'
                      },
                    },
                  };
                }
              
                
                var chart = new ApexCharts(document.querySelector("#dia_count"), options);
                chart.render();
                
                  
              }
            },
            error: function(error) {
             console.log(error);
            }
           });
      }
      if (tab_active == 'ill_count') {
        $.ajax({
          url: "/stat/date",
          type:"POST",
          data:{
            date: date,
            check: check_but,
            tab: tab_active,
            _token: _token
          },
          success:function(response){
            if(response) {
              // $('#all_count').remove();
              // $('#pol_count').remove();
              // $('#age_count').remove();
              // $('#come_count').remove();
              // $('#dia_count').remove();
              $('#ill_count').remove();
              $('#solid-rounded-tab6').after("<div id='ill_count'></div>");
              var death_count = response.death_count;
              var live_count = response.live_count;
              var date_array = response.date_array;
              var check_count = response.check_count;
              if (check_count) {
                var options = {
                  series: [{
                    name: lebel,
                    data: check_count
                  }],
                  chart: {
                    height: 350,
                    type: 'area'
                  },
                  dataLabels: {
                    enabled: false
                  },
                  stroke: {
                    curve: 'smooth'
                  },
                  title: {
                    name: lebel,
                    align: 'top'
                  },
                  xaxis: {
                    type: 'date',
                    categories: date_array
                  },
                  tooltip: {
                    x: {
                      format: 'dd/MM/yy'
                    },
                  },
                };
              } else {
                var options = {
                  series: [{
                    name: 'live',
                    data: live_count
                  },{
                    name: 'death',
                    data: death_count
                  }],
                  chart: {
                    height: 350,
                    type: 'area'
                  },
                  dataLabels: {
                    enabled: false
                  },
                  stroke: {
                    curve: 'smooth'
                  },
                  xaxis: {
                    type: 'date',
                    categories: date_array
                  },
                  tooltip: {
                    x: {
                      format: 'dd/MM/yy'
                    },
                  },
                };
              }
    
              
              
              var chart = new ApexCharts(document.querySelector("#ill_count"), options);
              chart.render();
                
            }
          },
          error: function(error) {
           console.log(error);
          }
         });
        }
    });

};

function tabFunction(tab_text){

  $("#solid-rounded-tab1").attr('title',tab_text);
  var val_date = $("#age_button").val();
  dateChart(val_date);

}
function checkFunction(tab_text){

  var arr = [];
  var arr_t = [];
  $('input:checkbox:checked').each(function () {
    arr.push($(this).val());
  });
  $.each(arr, function( index, value ) {
    var sd = $(`label#${value}`).text();
    arr_t.push(sd);
  });
  let arr_length =  arr.length;
  if (arr_length == 0) {
  $("#chec_select").val('none');
  $("#chec_select").text('Выбрать');

    
  } else {
    $("#chec_select").text(arr_t.toString());
  $("#chec_select").val(arr);
  }
  

  var val_date = $("#age_button").val();
  dateChart(val_date);
}

window.onload = function() {
    var val_date = $("#age_button").val();
  dateChart(val_date);
} 


function tabFunctionOne(tab_text){

  $("#solid-rounded-tab_one1").attr('title',tab_text);
  var val_date = $("#age_button_one").val();
  dateChart(val_date);

}

  function oneFunction(now_date)
  {
    var date = now_date;
    var _token   = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      url: "/stat/status",
      type:"POST",
      data:{
        date: date,
        _token: _token
      },
      success:function(response){
        if(response) {
           $('#pol_one').remove();
           $('#age_one').remove();
           $('#ill_one').remove();
           $('#skori_one').remove();
           $('#death_one').remove();
           $('#pol_one_id').after("<div id='pol_one'></div>");
           $('#age_one_id').after("<div id='age_one'></div>");
           $('#ill_one_id').after("<div id='ill_one'></div>");
           $('#skori_one_id').after("<div id='skori_one'></div>");
           $('#death_one_id').after("<div id='death_one'></div>");
           var pol_count = response.pol_count
           var age_cat = response.age_cat
           var age_count = response.age_count
           var ill_count = response.ill_count
           var skori_count = response.skori_count
           var death_count = response.death_count
           var pol = {
            colors: ['#008B8B','#FF7F50'],
            series: pol_count,
            chart: {
            width: 380,
            type: 'pie',
          },
          legend: {
            position: 'bottom'
          },
          labels: ['male', 'female'],
          responsive: [{
            breakpoint: 480,
            options: {
              chart: {
                width: 200
              },
            }
          }]
          };
          
          var pchart = new ApexCharts(document.querySelector("#pol_one"), pol);
          pchart.render();

          var age_charts = {
            series: [{
            data: age_count
          }],
            chart: {
            height: 350,
            type: 'bar',
            events: {
              click: function(chart, w, e) {
                // console.log(chart, w, e)
              }
            }
          },
          colors: ['#C71585', '#191970', '#FFA500', '#2F4F4F', '#008000', '#000000'],
          plotOptions: {
            bar: {
              columnWidth: '45%',
              distributed: true,
            }
          },
          dataLabels: {
            enabled: false
          },
          legend: {
            show: false
          },
          xaxis: {
            categories: age_cat,
            labels: {
              style: {
                colors: ['#C71585', '#191970', '#FFA500', '#2F4F4F', '#008000', '#000000'],
                fontSize: '12px'
              }
            }
          }
          };
          
          var achart = new ApexCharts(document.querySelector("#age_one"), age_charts);
          achart.render();


          var illness = {
            series: [{
            data: ill_count
          }],
            chart: {
            type: 'bar',
            height: 430
          },
          plotOptions: {
            bar: {
              horizontal: true,
              dataLabels: {
                position: 'top',
              },
            }
          },
          dataLabels: {
            enabled: true,
            offsetX: -6,
            style: {
              fontSize: '12px',
              colors: ['#fff']
            }
          },
          stroke: {
            show: true,
            width: 1,
            colors: ['#fff']
          },
          tooltip: {
            shared: true,
            intersect: false
          },
          xaxis: {
            categories: ['АГ', 'СД II тип', 'Ожирение', 'Гиперлипедемия'
          ],
          },
          };
  
          var illchart = new ApexCharts(document.querySelector("#ill_one"), illness);
          illchart.render();


          var skori = {
            colors: ['#006400','#DC143C'],
            series: skori_count,
            chart: {
            width: 380,
            type: 'pie',
          },
          legend: {
            position: 'bottom'
          },
          labels: ['Самотек','Скорой'],
          responsive: [{
            breakpoint: 480,
            options: {
              chart: {
                width: 200
              },
            }
          }]
          };
          
          var schart = new ApexCharts(document.querySelector("#skori_one"), skori);
          schart.render();
        
          var death = {
            colors: ['#008000','#DC143C'],
            series: pol_count,
            chart: {
            width: 380,
            type: 'pie',
          },
          legend: {
            position: 'bottom'
          },
          labels: ['live', 'death'],
          responsive: [{
            breakpoint: 480,
            options: {
              chart: {
                width: 200
              },
            }
          }]
          };
          
          var dchart = new ApexCharts(document.querySelector("#death_one"), death);
          dchart.render();
        
        }
      },
      error: function(error) {
       console.log(error);
      }
     });
    
    
    
    
    
  }


