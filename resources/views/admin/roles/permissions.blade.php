@extends('adminlte::page')

@section('title', 'Permissões')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> Permissões para {{$role->name}}</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">                    
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item active">Permissões para {{$role->name}}</li>
        </ol>
    </div>
</div>
@stop

@section('content')

    <div class="row">
        <div class="col-12 mb-2">
            <a class="text-success" href="{{route('role.index')}}">← Voltar para a Listagem</a>

            @if($errors->all())
                @foreach($errors->all() as $error)
                    @message(['color' => 'danger'])
                    {{ $error }}
                    @endmessage
                @endforeach
            @endif 

            @if(session()->exists('message'))
                @message(['color' => session()->get('color')])
                {{ session()->get('message') }}
                @endmessage
            @endif
        </div>            
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-teal card-outline">

                    <div class="card-body">
                    @if($permissions->count() > 0)    
                    <form class="mt-3 d-inline" action="{{route('role.permissionsSync', ['role' => $role->id])}}" method="post"> 
                        @csrf
                        @method('PUT')      
                        @foreach($permissions as $permission)                       
                                                                
                            <div class="form-group p-3 mb-1 col-12 col-sm-6 col-md-4 col-lg-3" style="float:left;">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="{{$permission->id}}" name="{{$permission->id}}" {{($permission->can == '1' ? 'checked' : '')}}>
                                    <label for="{{$permission->id}}" class="form-check-label">{{$permission->name}}</label>
                                </div>
                            </div>                             
                        
                        @endforeach
                    </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="float-right">
                                <button type="submit" class="btn btn-success btn-lg">Sincronizar Perfil</button>
                            </div>
                        </div>
                        <!-- /.card-footer -->
                    </form>
                    @endif
                
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>

@endsection