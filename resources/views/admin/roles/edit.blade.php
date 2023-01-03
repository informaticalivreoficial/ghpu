@extends('adminlte::page')

@section('title', 'Editar Perfil')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i>Editar Perfil</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('role.index')}}">Perfis</a></li>
            <li class="breadcrumb-item active">Editar Perfil</li>
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
                <form action="{{route('role.update', ['role' => $role->id])}}" method="post" autocomplete="off">
                    @csrf 
                    @method('PUT')
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Perfil</label>
                        <input type="text" class="form-control input-lg" placeholder="Nome do Perfil" id="name" name="name" value="{{old('name') ?? $role->name}}">                                
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="float-right">
                        <button type="submit" class="btn btn-success btn-lg">Atualizar Perfil</button>
                    </div>
                </div>
                <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection