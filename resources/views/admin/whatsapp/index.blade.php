@extends('adminlte::page')

@section('title', 'Gerenciar Números')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-suitcase mr-2"></i> {{$lista->titulo}}</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">                    
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('listas.whatsapp')}}">Listas</a></li>
            <li class="breadcrumb-item active">Números</li>
        </ol>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header text-right">
        <a href="{{route('lista.numero.create')}}" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Número</a>
    </div>        
    <!-- /.card-header -->
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
        @if(!empty($numeros) && $numeros->count() > 0)
            <table class="table table-bordered table-striped projects">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="text-center">Número</th>
                        <th class="text-center">Cadastro</th>
                        <th class="text-center">Autorizado</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($numeros as $numero)                    
                    <tr style="{{ ($numero->status == '1' ? '' : 'background: #fffed8 !important;')  }}">                            
                        <td>{{ $numero->nome }}</td>
                        <td class="text-center">{{ $numero->numero }}</td>
                        <td class="text-center">{{ $numero->created_at }}</td>                           
                        <td class="text-center">{!! $numero->autorizacao !!}</td>                           
                        <td class="acoes">
                            <input type="checkbox" data-onstyle="success" data-offstyle="warning" data-size="mini" class="toggle-class" data-id="{{ $numero->id }}" data-toggle="toggle" data-style="slow" data-on="<i class='fas fa-check'></i>" data-off="<i style='color:#fff !important;' class='fas fa-exclamation-triangle'></i>" {{ $numero->status == true ? 'checked' : ''}}>
                            @if($numero->numero != '')
                                <a target="_blank" href="{{\App\Helpers\WhatsApp::getNumZap($numero->numero)}}" class="btn btn-xs btn-success text-white"><i class="fab fa-whatsapp"></i></a>
                            @endif
                            <a data-toggle="tooltip" data-placement="top" title="Editar Número" href="{{route('lista.numero.edit',['id' => $numero->id])}}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                            <button data-placement="top" title="Remover Número" type="button" class="btn btn-xs btn-danger text-white j_modal_btn" data-id="{{$numero->id}}" data-toggle="modal" data-target="#modal-default"><i class="fas fa-trash"></i></button>
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
        {{ $numeros->links() }}          
    </div>   
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frm" action="" method="post">            
            @csrf
            @method('DELETE')
            <input id="id_numero" name="numero_id" type="hidden" value=""/>
                <div class="modal-header">
                    <h4 class="modal-title">Remover Número!</h4>
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
@stop

@section('footer')
    <strong>Copyright &copy; {{env('DESENVOLVEDOR_INICIO')}} <a href="{{env('DESENVOLVEDOR_URL')}}">{{env('DESENVOLVEDOR')}}</a>.</strong> Desenvolvido por <a href="https://informaticalivre.com.br">Informática Livre</a>.
@endsection

{{-- @section('plugins.Toastr', true) --}}

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
<link href="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.css'))}}" rel="stylesheet">
@stop

@section('js')
    <script src="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.js'))}}"></script>
    <script>
       $(function () {           
           
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           
            //FUNÇÃO PARA EXCLUIR
            $('.j_modal_btn').click(function() {
                var numero_id = $(this).data('id');                
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('lista.numero.delete') }}",
                    data: {
                       'id': numero_id
                    },
                    success:function(data) {
                        if(data.error){
                            $('.j_param_data').html(data.error);
                            $('#id_numero').val(data.id);
                            $('#frm').prop('action','{{ route('lista.numero.deleteon') }}');
                        }else{
                            $('#frm').prop('action','{{ route('lista.numero.deleteon') }}');
                        }
                    }
                });
            });
            
            $('#toggle-two').bootstrapToggle({
                on: 'Enabled',
                off: 'Disabled'
            });
            
            $('.toggle-class').on('change', function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var numero_id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('lista.numero.SetStatus') }}",
                    data: {
                        'status': status,
                        'id': numero_id
                    },
                    success:function(data) {
                        
                    }
                });
            });
        });
    </script>
@endsection