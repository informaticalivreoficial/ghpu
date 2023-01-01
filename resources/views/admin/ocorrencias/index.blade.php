@extends('adminlte::page')

@section('title', 'Gerenciar Ocorrências')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> Gerenciar Ocorrências</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">                    
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
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
            @if(!empty($empresas) && $empresas->count() > 0)
                <table id="example1" class="table table-bordered table-striped projects">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Empresa</th>
                            <th class="text-center">Ocorrências</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($empresas as $empresa)
                        <tr>
                            <td class="text-center">
                                <a href="{{$empresa->nocover()}}" data-title="{{$empresa->alias_name}}" data-toggle="lightbox">
                                    <img style="width: 50px;" alt="{{$empresa->alias_name}}" src="{{$empresa->cover()}}">
                                </a>
                            </td>
                            <td>{{$empresa->alias_name}}</td>
                            <td class="text-center"><span class="bg-info p-1">{{$empresa->ocorrencias->count()}}</span></td>                            
                            <td>
                                <a title="Visualizar Ocorrências" href="{{route('ocorrencias.view', [ 'empresa' => $empresa->id ])}}" class="btn btn-xs btn-info text-white"><i class="fas fa-search"></i></a>
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
            {{ $empresas->links() }}
        </div>
        <!-- /.card-body -->
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

        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
            alwaysShowClose: true
            });
        });

    });
</script>
@endsection