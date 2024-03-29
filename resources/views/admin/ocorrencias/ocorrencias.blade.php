@extends('adminlte::page')

@section('title', 'Gerenciar Ocorrências')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> Ocorrências {{(!empty($empresa) ? $empresa->alias_name : '')}}</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">                    
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            @if (auth()->user()->superadmin == true)
                <li class="breadcrumb-item"><a href="{{route('ocorrencias.index')}}">Listar Empresas</a></li>
            @endif
            <li class="breadcrumb-item active">Gerenciar Ocorrências</li>
        </ol>
    </div>
</div>
@stop

@section('content')

    <div class="card">        
        <div class="card-header">
            <div class="row">
                <div class="col-12">                
                    @if(session()->exists('message'))
                        @message(['color' => session()->get('color')])
                            {{ session()->get('message') }}
                        @endmessage
                    @endif
                </div>            
            </div>
            <div class="card-tools">
                <form action="{{route('ocorrencias.search')}}" method="post">
                    @csrf
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="filter" value="{{$filter ?? ''}}" class="form-control float-right" placeholder="Pesquisar">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">            
            @if(!empty($ocorrencias) && $ocorrencias->count() > 0)
                <table id="example1" class="table table-bordered table-striped projects">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Colaborador</th>
                            <th class="text-center">Data/Hora</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($ocorrencias as $ocorrencia)
                        <tr>
                            <td class="tooltip-demo well">                                
                                @if($ocorrencia->visualizacoes()->get()->count())
                                <a data-html="true" rel="tooltip" href="javascript:void(0)" title="
                                    @foreach($ocorrencia->visualizacoes()->get() as $ass)
                                    {{$ass->usuario->name}} <br>
                                    @endforeach
                                    ">{{$ocorrencia->titulo}}</a>
                                @else
                                    {{$ocorrencia->titulo}}
                                @endif
                                </td>
                            <td>{{$ocorrencia->user->name}}</td>
                            <td class="text-center">{{\Carbon\Carbon::parse($ocorrencia->created_at)->format('d/m/Y - H:i')}}</td>                            
                            <td>
                                <input type="checkbox" data-onstyle="success" data-offstyle="warning" data-size="mini" class="toggle-class" data-id="{{ $ocorrencia->id }}" data-toggle="toggle" data-style="slow" data-on="<i class='fas fa-check'></i>" data-off="<i style='color:#fff !important;' class='fas fa-exclamation-triangle'></i>" {{ $ocorrencia->status == true ? 'checked' : ''}}>
                                <a title="Visualizar Ocorrência" href="{{route('ocorrencia.view', [ 'ocorrencia' => $ocorrencia->id ])}}" class="btn btn-xs btn-info text-white"><i class="fas fa-search"></i></a>
                                <a href="{{route('ocorrencias.edit',['id' => $ocorrencia->id])}}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                <button type="button" class="btn btn-xs btn-danger text-white j_modal_btn" data-id="{{$ocorrencia->id}}" data-toggle="modal" data-target="#modal-default">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>                            
                        </tr>
                        @endforeach
                    </tbody>                
                </table>
            @else
                <div class="row mb-4">
                    <div class="col-12">                                                        
                        <div class="alert alert-info p-3">
                            Não foram encontrados registros!
                        </div>                                                        
                    </div>
                </div>
            @endif         
        </div>
        <div class="card-footer paginacao">  
            {{ $ocorrencias->links() }}
        </div>
        <!-- /.card-body -->
    </div>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="frm" action="" method="post">            
                @csrf
                @method('DELETE')
                <input id="id_ocorrencia" name="ocorrencia_id" type="hidden" value=""/>
                    <div class="modal-header">
                        <h4 class="modal-title">Remover Ocorrência!</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span class="j_param_data"></span>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                        <button type="submit" class="btn btn-primary">Excluir Agora</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>
    .pagination-custom{
            margin: 0;
            display: -ms-flexbox;
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
        }
        .pagination-custom li a {
            border-radius: 30px;
            margin-right: 8px;
            color:#7c7c7c;
            border: 1px solid #ddd;
            position: relative;
            float: left;
            padding: 6px 12px;
            width: 50px;
            height: 40px;
            text-align: center;
            line-height: 25px;
            font-weight: 600;
        }
        .pagination-custom>.active>a, .pagination-custom>.active>a:hover, .pagination-custom>li>a:hover {
            color: #fff;
            background: #007bff;
            border: 1px solid transparent;
        }
</style>
<link rel="stylesheet" href="{{url(asset('backend/plugins/ekko-lightbox/ekko-lightbox.css'))}}">
<link href="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.css'))}}" rel="stylesheet">
@stop

@section('js')
<script src="{{url(asset('backend/plugins/ekko-lightbox/ekko-lightbox.min.js'))}}"></script>
<script src="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.js'))}}"></script>
<script>
    $('.tooltip-demo.well').tooltip({
        selector: "a[rel=tooltip]"
    });
   $(function () { 
       
       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.j_modal_btn').click(function() {
            var ocorrencia_id = $(this).data('id');
            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: "{{ route('ocorrencias.delete') }}",
                data: {
                   'id': ocorrencia_id
                },
                success:function(data) {
                    if(data.error){
                        $('.j_param_data').html(data.error);
                        $('#id_ocorrencia').val(data.id);
                        $('#frm').prop('action','{{ route('ocorrencias.deleteon') }}');
                    }else{
                        $('#frm').prop('action','{{ route('ocorrencias.deleteon') }}');
                    }
                }
            });
        });

        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
            alwaysShowClose: true
            });
        });

        $('.toggle-class').on('change', function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var empresa_id = $(this).data('id');
            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: "{{ route('ocorrencias.setStatus') }}",
                data: {
                    'status': status,
                    'id': empresa_id
                },
                success:function(data) {
                    
                }
            });
        });

    });
</script>
@endsection