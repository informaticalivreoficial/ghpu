@extends('admin.master.master')

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cadastrar Perfil</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Cadastrar Perfil</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content text-muted">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mb-2">
                    <a class="text-success" href="{{route('admin.role.index')}}">← Voltar para a Listagem</a>

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
                        <form action="{{route('admin.role.store')}}" method="post" autocomplete="off">
                            @csrf                           
                        
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Perfil</label>
                                <input type="text" class="form-control input-lg" placeholder="Nome do Perfil" id="name" name="name" value="{{old('name')}}">                                
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="float-right">
                                <button type="submit" class="btn btn-success btn-lg">Cadastrar Perfil</button>
                            </div>
                        </div>
                        <!-- /.card-footer -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

@endsection