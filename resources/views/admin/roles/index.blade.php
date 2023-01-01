@extends('admin.master.master')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-search mr-2"></i> Perfis</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Painel de Controle</a></li>
                    <li class="breadcrumb-item active">Perfis</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">

    <div class="card card-teal card-outline">
        <div class="card-header text-right">
            <a href="{{route('admin.role.create')}}" class="btn btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Perfil</a>
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
            @if(!empty($roles) && $roles->count() > 0)
                <table id="example1" class="table table-bordered table-striped projects">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Perfil</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($roles as $role)                        
                        <tr>                            
                            <td>{{$role->id}}</td>
                            <td>{{$role->name}}</td>
                            <td>
                                <a href="{{route('admin.role.edit',['role' => $role->id])}}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                <a class="btn btn-xs btn-outline-success" href="{{ route('admin.role.permissions', ['role' => $role->id]) }}">Permissões</a>
                                <button type="button" class="btn btn-xs btn-danger text-white j_modal_btn" data-id="{{$role->id}}" data-toggle="modal" data-target="#modal-default"><i class="fas fa-trash"></i></button>
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
    </div>

<!-- /.card -->   
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frm" action="" method="post">            
            @csrf
            @method('DELETE')
            <input id="id_role" name="role_id" type="hidden" value=""/>
                <div class="modal-header">
                    <h4 class="modal-title">Remover Perfil!</h4>
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
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</section>

@endsection

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
                var role_id = $(this).data('id');
                
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('admin.role.delete') }}",
                    data: {
                       'id': role_id
                    },
                    success:function(data) {
                        if(data.error){
                            $('.j_param_data').html(data.error);
                            $('#id_role').val(data.id);
                            $('#frm').prop('action','{{ route('admin.role.deleteon') }}');
                        }else{
                            $('#frm').prop('action','{{ route('admin.role.deleteon') }}');
                        }
                    }
                });
            });
            
        });
    </script>
@endsection