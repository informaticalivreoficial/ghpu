@extends('adminlte::page')

@section('title', 'Painel de Controle')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Painel de Controle</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Início</a></li>
            <li class="breadcrumb-item active">Painel de Controle</li>
        </ol>
    </div><!-- /.col -->
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="info-box">
            <span class="info-box-icon bg-info"><a href="{{ route('empresas.index') }}" title="Empresas"><i class="fa far fa-industry"></i></a></span>

            <div class="info-box-content">
                <span class="info-box-text"><b>Empresas</b></span>
                <span class="info-box-text">Ativas: {{$empresasAvailable}}</span>
                <span class="info-box-text">Inativas: {{$empresasUnavailable}}</span>
                <span class="info-box-text">Total: {{$empresasAvailable + $empresasUnavailable}}</span>
            </div>            
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="info-box">
            <span class="info-box-icon bg-info"><a href="{{ route('ocorrencias.index') }}" title="Ocorrências"><i class="fa far fa-file"></i></a></span>

            <div class="info-box-content">
                <span class="info-box-text"><b>Ocorrências</b></span>
                <span class="info-box-text">Publicado: {{$ocorrenciasAvailable}}</span>
                <span class="info-box-text">Rascunho: {{$ocorrenciasUnavailable}}</span>
                <span class="info-box-text">Total: {{$ocorrenciasAvailable + $ocorrenciasUnavailable}}</span>
            </div>            
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="info-box">
            <span class="info-box-icon bg-teal"><a href="{{ route('users.index') }}" title="Clientes"><i class="fa far fa-users"></i></a></span>

            <div class="info-box-content">
                <span class="info-box-text"><b>Usuários</b></span>
                <span class="info-box-text">Time: {{ $time }}</span>
                <span class="info-box-text">Colaboradores: {{ $colaboradores }}</span>
                <span class="info-box-text">Total: {{ $colaboradores + $time }}</span>
            </div>
        </div>
    </div> 
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
       
    </div>       
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        
    </div>
</div>

<div class="row">
    <section class="col-lg-6 connectedSortable">
            <!-- BAR CHART -->
            <div class="card card-teal">
                <div class="card-header">
                    <h3 class="card-title">Visitas/Últimos 6 meses</h3>

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <section class="col-lg-6 connectedSortable">
        <!-- DONUT CHART -->
        <div class="card card-teal">
            <div class="card-header">
            <h3 class="card-title">Dispositivos/Últimos 6 meses</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
            </div>
            <div class="card-body">
            <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </section>
    </div><!-- /.row -->




</section>
@stop

@section('footer')

    <div class="pull-right hidden-xs">
      <b>Versão</b> {{env('VERSAO_SISTEMA')}}
    </div>
    <strong>Copyright © 2005 - {{date('Y')}} <a href="https://informaticalivre.com.br">Informática Livre</a>.</strong>
  
@endsection

@section('css')
<link rel="stylesheet" href="{{url(asset('backend/plugins/ekko-lightbox/ekko-lightbox.css'))}}">
<style>
    .info-box .info-box-content {   
        line-height: 120%;
    }
</style>
@endsection

@section('js')
<script src="{{url(asset('backend/plugins/ekko-lightbox/ekko-lightbox.min.js'))}}"></script>
    <script>  
    $(function (){

        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
            alwaysShowClose: true
            });
        }); 

        @php
        if($analyticsData->rows != null){
        @endphp
            var areaChartData = {
                labels  : [
                @foreach($analyticsData->rows as $dataMonth)                
                    'Mês/{{substr($dataMonth[0], -2)}}',                                 
                @endforeach
                ],
                datasets: [
                    {
                    label               : 'Visitas Únicas',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : [
                                        @foreach($analyticsData->rows as $dataMonth)                
                                            '{{$dataMonth[2]}}',                                 
                                        @endforeach
                                        ]
                    },
                    {
                    label               : 'Visitas',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : [
                                        @foreach($analyticsData->rows as $dataMonth)                
                                            '{{$dataMonth[1]}}',                                 
                                        @endforeach
                                        ]
                    },
                ]
            }
        @php    
        }
        @endphp
        

        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = jQuery.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0

        var barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false
        }

        var barChart = new Chart(barChartCanvas, {
        type: 'bar', 
        data: barChartData,
        options: barChartOptions
        });

        function dynamicColors() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgba(" + r + "," + g + "," + b + ", 0.5)";
        }

        //-------------
        //- DONUT CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData        = {
          labels: [
              @if(!empty($top_browser))
                @foreach($top_browser as $browser)
                  '{{$browser['browser']}}',
                @endforeach
              @else
                'Chrome', 
                'IE',
                'FireFox', 
                'Safari', 
                'Opera', 
                'Navigator',
              @endif               
          ],
          datasets: [
            {
              data: [
                @if(!empty($top_browser))
                  @foreach($top_browser as $key => $browser)
                    {{$browser['sessions']}},
                  @endforeach
                @else
                  700,500,400,600,300,100
                @endif                
                ],
              backgroundColor : [
                @foreach($top_browser as $key => $browser)
                  dynamicColors(),
                @endforeach
                ],
            }
          ]
        }
        var donutOptions     = {
          maintainAspectRatio : false,
          responsive : true,
        }

        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        var donutChart = new Chart(donutChartCanvas, {
          type: 'doughnut',
          data: donutData,
          options: donutOptions      
        });

            
    }); 

       
    </script>
@stop
