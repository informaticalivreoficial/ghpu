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
            <li class="breadcrumb-item"><a href="{{route('ocorrencias.index')}}">Listar Empresas</a></li>
            <li class="breadcrumb-item active">Gerenciar Ocorrências</li>
        </ol>
    </div>
</div>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">                
                    @if(session()->exists('message'))
                        @message(['color' => session()->get('color')])
                            {{ session()->get('message') }}
                        @endmessage
                    @endif
                </div>            
            </div>
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
                            <td>{{$ocorrencia->titulo}}</td>
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
<link rel="stylesheet" href="{{url(asset('backend/plugins/ekko-lightbox/ekko-lightbox.css'))}}">
<link href="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.css'))}}" rel="stylesheet">
@stop

@section('js')
<script src="{{url(asset('backend/plugins/ekko-lightbox/ekko-lightbox.min.js'))}}"></script>
<script src="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.js'))}}"></script>
<script>
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