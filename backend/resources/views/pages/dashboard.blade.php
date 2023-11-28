@extends('layouts.master')
@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
            @if(session('success'))
            <div id="flash-message" class="alert alert-success">
              {{ session('success') }}
            </div>
            @endif
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">

            {{-- VISITOR --}}
            <div class="col-lg-12 col-6 text-center">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner p-4">
                <h1 class="font-weight-bold">{{$activeUsers}}</h1>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <div class="card-footer bg-light border-success">Visitors</div>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3>{{$jobData}}</h3>
                <p>Careers</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('show-career')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$articleData}}</h3>

                <p>Articles</p>
              </div>
              <div class="icon">
                <i class="fas fa-stream"></i>
              </div>
              <a href="{{route('show-blog')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$portofolioData}}</h3>

                <p>Portofolio</p>
              </div>
              <div class="icon">
                <i class="fas fa-file-alt"></i>
              </div>
              <a href="{{route('show-portofolio')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$productData}}</h3>

                <p>Products</p>
              </div>
              <div class="icon">
                <i class="fas fa-tags"></i>
              </div>
              <a href="{{route('show-product')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- solid sales graph -->
            <div class="card bg-gradient-info">
                <div class="card-header border-0">
                    <h3 class="card-title">
                    <i class="fas fa-th mr-1"></i>
                    Visitor Graph
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm daterange-chart" title="Date range">
                            <i class="far fa-calendar-alt"></i>
                          </button>
                    <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.card-body -->
                <div class="card-footer bg-transparent">
                    <div class="row">
                    <div class="col-4 text-center">
                        <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
                                data-fgColor="#39CCCC">

                        <div class="text-white">Mail-Orders</div>
                    </div>
                    <!-- ./col -->
                    <div class="col-4 text-center">
                        <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
                                data-fgColor="#39CCCC">

                        <div class="text-white">Online</div>
                    </div>
                    <!-- ./col -->
                    <div class="col-4 text-center">
                        <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
                                data-fgColor="#39CCCC">

                        <div class="text-white">In-Store</div>
                    </div>
                    <!-- ./col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-footer -->
                </div>
                <!-- /.card -->

            <!-- DIRECT CHAT -->
            <div class="card direct-chat direct-chat-primary">
              <div class="card-header bg-secondary">
                  <h3 class="card-title">
                    <i class="fas fa-history"></i>
                    Edit History
                  </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Action</th>
                        <th>Section</th>
                        <th>Message</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Time</th>
                    </tr>
                    @foreach($editRecord as $record)
                    <tr>
                        <td>{{$record->action}}</td>
                        <td>{!!$record->section!!}</td>
                        <td class="w-25">{!! $record->message !!}</td>
                        <td>{{$record->user->firstname ." ". $record->user->lastname}}</td>
                        <td>{{$record->user->role->role_name}}</td>
                        <td>{{$record->created_at}}</td>
                    </tr>
                    @endforeach
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                {{$editRecord->links('pagination::bootstrap-4')}}
              </div>
              <!-- /.card-footer-->
            </div>
            <!--/.direct-chat -->

            <!-- TO DO List -->
            @include('cms.ToDoList.todolist')
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

            <!-- Map card -->
            <div class="card bg-gradient-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-map-marker-alt mr-1"></i>
                  Visitors Geomap
                </h3>
                <!-- card tools -->
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                    <i class="far fa-calendar-alt"></i>
                  </button>
                  <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
                <div id="world-map" style="height: 250px; width: 100%;"></div>
              </div>
              <!-- /.card-body-->
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-12 text-center">
                    <h3>Jawa Barat</h3>
                    <div class="text-white">Visitors</div>
                    <canvas class="chart" id="geomap-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                  {{-- <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-2"></div>
                    <div class="text-white">Online</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-3"></div>
                    <div class="text-white">Sales</div>
                  </div>
                  <!-- ./col --> --}}
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.card -->

            <!-- solid sales graph -->
            <div class="card bg-gradient-info">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-sign-in-alt"></i>
                    Login Record
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-striped text-center">
                @foreach($loginRecords as $loginRecord)
                    <tr class="">
                        <td>
                            {{$loginRecord->user->firstname . $loginRecord->user->lastname}}
                        </td>
                        <td class="text-end">
                            {{$loginRecord->role->role_name}}
                        </td>
                        <td>
                            {{$loginRecord->created_at}}
                        </td>
                    </tr>
                    @endforeach
                </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer bg-transparent justify-content-center">
                    <div class="row">
                        <div class="mx-auto">
                            {{$loginRecords->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->

            <!-- Calendar -->
            <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <!-- button with a dropdown -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                      <i class="fas fa-bars"></i>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a href="#" class="dropdown-item">Add new event</a>
                      <a href="#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
<script>

$(function () {
  'use strict'
    //DATA FOR GEOMAP
  var arrayMap = {!!json_encode($dataMap)!!}
    function findRegion(regionName) {
        return arrayMap.find(item => item.region === regionName);
    }

  // World map by jvectormap
  $('#world-map').vectorMap({
    map: 'indonesia_id',
    backgroundColor: 'transparent',
    regionStyle: {
      initial: {
        fill: 'rgba(255, 255, 255, 0.7)',
        'fill-opacity': 1,
        stroke: 'rgba(0,0,0,.2)',
        'stroke-width': 1,
        'stroke-opacity': 1
      }
    },
    series: {
      regions: [{
        values: arrayMap,
        scale: ['#ffffff', '#0154ad'],
        normalizeFunction: 'polynomial'
      }]
    },
    onRegionLabelShow: function (e, el, code) {
      if (typeof visitorsData[code] !== 'undefined') {
        el.html(el.html() + ': ' + visitorsData[code] + ' new visitors')
      }
    },onRegionClick: function (e, code, region) {
        var visitorRegion = findRegion(region);
        geoMapChartData.labels = visitorRegion.date
        geoMapChartData.datasets[0].data = visitorRegion.metric;
        geoMapChart.update();
  }
  })
     // Geo Map chart
     var geoMapChartCanvas = $('#geomap-chart').get(0)
  geoMapChartCanvas.getContext('2d')
  // $('#revenue-chart').get(0).getContext('2d');

  var geoMapChartData = {
    // labels: ['2011 Q1', '2011 Q2', '2011 Q3', '2011 Q4', '2012 Q1', '2012 Q2', '2012 Q3', '2012 Q4', '2013 Q1', '2013 Q2'],
    labels: arrayMap[0].date,
    datasets: [
      {
        label: 'Visitors',
        fill: false,
        borderWidth: 2,
        lineTension: 0,
        spanGaps: true,
        borderColor: '#efefef',
        pointRadius: 3,
        pointHoverRadius: 7,
        pointColor: '#efefef',
        pointBackgroundColor: '#efefef',
        data: arrayMap[0].metric
        // data: [2666, 2778, 4912, 3767, 6810, 5670, 4820, 15073, 10687, 8432]
      }
    ]
  }

  var geoMapChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        ticks: {
          fontColor: '#efefef'
        },
        gridLines: {
          display: false,
          color: '#efefef',
          drawBorder: false
        }
      }],
      yAxes: [{
        ticks: {
          stepSize: 5,
          fontColor: '#efefef'
        },
        gridLines: {
          display: true,
          color: '#efefef',
          drawBorder: true
        }
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
  // eslint-disable-next-line no-unused-vars
  var geoMapChart = new Chart(geoMapChartCanvas, { // lgtm[js/unused-local-variable]
    type: 'bar',
    data: geoMapChartData,
    options: geoMapChartOptions
  })

  $('.daterange').daterangepicker({
    ranges: {
      Today: [moment(), moment()],
      Yesterday: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment().subtract(29, 'days'),
    endDate: moment()
  }, function (start, end) {
    // eslint-disable-next-line no-alert
    var startDate = start.format('YYYY-MM-DD')
    var endDate = end.format('YYYY-MM-DD')
    $.ajax({
        type: "GET",
        url: '{{route('map-costum')}}',
        dataType: "json",
        data: {
        'startDate': start.format('YYYY-MM-DD'),
        'endDate': end.format('YYYY-MM-DD'),
        },
        success: function (response) {
            var firstElement = response[0];
            if (Array.isArray(firstElement.date) && Array.isArray(firstElement.metric)) {
            var numericMetrics = firstElement.metric.map(Number);

            geoMapChartData.labels = firstElement.date;
            geoMapChartData.datasets[0].data = numericMetrics;
            geoMapChart.update();
        }
        },
        error: function (xhr, status, error) {
        console.log('gagal');
            console.log(xhr.responseText);  // Tampilkan respon kesalahan lengkap
            console.log(status);  // Tampilkan status kesalahan (misalnya: "Not Found", "Internal Server Error", dll.)
            console.log(error);  // Tampilkan pesan kesalahan jika ada
    }
    });
  })









  // The Calender
  $('#calendar').datetimepicker({
    format: 'L',
    inline: true
  })



  // Make the dashboard widgets sortable Using jquery UI
  $('.connectedSortable').sortable({
    placeholder: 'sort-highlight',
    connectWith: '.connectedSortable',
    handle: '.card-header, .nav-tabs',
    forcePlaceholderSize: true,
    zIndex: 999999
  })
  $('.connectedSortable .card-header').css('cursor', 'move')

  // jQuery UI sortable for the todo list
  $('.todo-list').sortable({
    placeholder: 'sort-highlight',
    handle: '.handle',
    forcePlaceholderSize: true,
    zIndex: 999999
  })

  // bootstrap WYSIHTML5 - text editor
  $('.textarea').summernote()

  /* jQueryKnob */
  $('.knob').knob()

  // SLIMSCROLL FOR CHAT WIDGET
  $('#chat-box').overlayScrollbars({
    height: '250px'
  })



      // Sales graph chart
  var salesGraphChartCanvas = $('#line-chart').get(0)
  salesGraphChartCanvas.getContext('2d')
  // $('#revenue-chart').get(0).getContext('2d');

  var salesGraphChartData = {
    // labels: ['2011 Q1', '2011 Q2', '2011 Q3', '2011 Q4', '2012 Q1', '2012 Q2', '2012 Q3', '2012 Q4', '2013 Q1', '2013 Q2'],
    labels: {!! json_encode($dataGraph[0]) !!},
    datasets: [
      {
        label: 'Visitors',
        fill: false,
        borderWidth: 2,
        lineTension: 0,
        spanGaps: true,
        borderColor: '#efefef',
        pointRadius: 3,
        pointHoverRadius: 7,
        pointColor: '#efefef',
        pointBackgroundColor: '#efefef',
        data: {!! json_encode($dataGraph[1]) !!}
        // data: [2666, 2778, 4912, 3767, 6810, 5670, 4820, 15073, 10687, 8432]
      }
    ]
  }

  var salesGraphChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        ticks: {
          fontColor: '#efefef'
        },
        gridLines: {
          display: false,
          color: '#efefef',
          drawBorder: false
        }
      }],
      yAxes: [{
        ticks: {
          stepSize: 5,
          fontColor: '#efefef'
        },
        gridLines: {
          display: true,
          color: '#efefef',
          drawBorder: false
        }
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
  // eslint-disable-next-line no-unused-vars
  var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
    type: 'line',
    data: salesGraphChartData,
    options: salesGraphChartOptions
  })



  $('.daterange-chart').daterangepicker({
    ranges: {
      Today: [moment(), moment()],
      Yesterday: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment().subtract(29, 'days'),
    endDate: moment()
  }, function (start, end) {
    // eslint-disable-next-line no-alert
    var startDate = start.format('YYYY-MM-DD')
    var endDate = end.format('YYYY-MM-DD')
    $.ajax({
        type: "GET",
        url: '{{route('ga-costum')}}',
        dataType: "json",
        data: {
        'startDate': start.format('YYYY-MM-DD'),
        'endDate': end.format('YYYY-MM-DD'),
        },
        success: function (response) {
            salesGraphChartData.labels = response[0]
            salesGraphChartData.datasets[0].data = response[1];
            salesGraphChart.update()
        },
        error: function (xhr, status, error) {
        console.log('gagal');
            // console.log(xhr.responseText);  // Tampilkan respon kesalahan lengkap
            // console.log(status);  // Tampilkan status kesalahan (misalnya: "Not Found", "Internal Server Error", dll.)
            // console.log(error);  // Tampilkan pesan kesalahan jika ada
    }
    });
  })






})
</script>
@endsection
