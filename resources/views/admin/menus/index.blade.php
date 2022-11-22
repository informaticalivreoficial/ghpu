@extends('adminlte::page')

@section('title', 'Gerenciar Links')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> Links</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item active">Links</li>
        </ol>
    </div>
</div>
@stop

@section('content')

    <div class="card">
        <div class="card-header text-right">
            <a href="{{route('menus.create',['cat_pai' => 'null'])}}" class="btn btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Link</a>
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
            @if(!empty($menus) && $menus->count() > 0)
                <table id="example1" class="table table-bordered table-striped projects">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th class="text-center">Exibir?</th>                            
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Link</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($menus as $menu)                        
                        <tr style="{{ ($menu->status == 'Sim' ? '' : 'background: #fffed8 !important;')  }}">                            
                            <td class="text-muted"><img src="{{url(asset('backend/assets/images/seta.png'))}}"/> <b>{{$menu->titulo}}</b></td>
                            <td class="text-center text-muted"> {{ ($menu->status == 'Sim' ? 'Sim' : 'Não')  }} </td>
                            <td class="text-center text-muted">{{$menu->tipo}}</td>
                            <td class="text-center text-muted">
                                <a target="_blank" href="{{($menu->tipo == 'Página' ? route('web.pagina', [ 'slug' => ($menu->post != null ? $menu->PostObject->slug : '404') ]) : $menu->url)}}"><i class="fas fa-link"></i></a>
                            </td>
                            <td>
                                <a href="{{route('menus.create', ['catpai' => $menu->id])}}" class="btn btn-xs btn-success">Criar Sub Link</a>
                                <a href="{{ route('menus.edit', [ 'id' => $menu->id]) }}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                <button type="button" class="btn btn-xs btn-danger text-white j_modal_btn" data-id="{{$menu->id}}" data-toggle="modal" data-target="#modal-default">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                            @if ($menu->children)
                                @foreach($menu->children as $submenu)                        
                                <tr>                            
                                    <td class="text-muted"><img src="{{url(asset('backend/assets/images/setaseta.png'))}}"/> {{$submenu->titulo}}</td>
                                    <td class="text-center text-muted">{{$submenu->status}}</td>
                                    <td class="text-center text-muted">{{$submenu->tipo}}</td>
                                    <td class="text-center text-muted">
                                        <a target="_blank" href="{{($submenu->tipo == 'Página' ? route('web.pagina', [ 'slug' => ($submenu->post != null ? $submenu->PostObject->slug : '404') ]) : $submenu->url)}}"><i class="fas fa-link"></i></a>
                                    </td>
                                    <td>
                                        <a href="{{ route('menus.edit', [ 'id' => $submenu->id ]) }}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                        <button type="button" class="btn btn-xs btn-danger text-white j_modal_btn" data-id="{{$submenu->id}}" data-toggle="modal" data-target="#modal-default">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
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
            {{ $menus->links() }}
        </div>
    </div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frm" action="" method="post">            
            @csrf
            @method('DELETE')
            <input id="id_link" name="link_id" type="hidden" value=""/>
                <div class="modal-header">
                    <h4 class="modal-title">Remover Link!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="j_param_data"></span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-primary onoff">Excluir Agora</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
    <script>
       $(function () {
           
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            //FUNÇÃO PARA EXCLUIR
            $('.j_modal_btn').click(function() {
                var link_id = $(this).data('id');
                
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('menus.delete') }}",
                    data: {
                       'id': link_id
                    },
                    success:function(data) {
                        if(data.erroron){   
                            $('.onoff').attr('disabled', false);
                            $('.j_param_data').html(data.erroron);
                            $('#id_link').val(data.id);
                            $('#frm').prop('action',"{{ route('menus.deleteon') }}");
                        }else if(data.error){
                            $('.onoff').attr('disabled', true);
                            $('.j_param_data').html(data.error);
                        }else{
                            $('.onoff').attr('disabled', false);
                            $('#id_link').val(data.id);
                            $('#frm').prop('action',"{{ route('menus.deleteon') }}");
                        }
                    }
                });
            });           
            
        });
    </script>
@stop