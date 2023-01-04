@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="wrapper main-sistema">
        <div class="row empresas-logo">
            @if (!empty($empresas) && $empresas->count() > 0)
                @foreach($empresas as $empresa)
                    <div class="col-md-3 empresas-logo-logo">
                        <a href="{{$empresa->link}}" title="{{$empresa->titulo}}">
                        <img alt="{{$empresa->titulo}}" src="{{$empresa->cover()}}"/>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </section>
@endsection

@section('css')
    
@endsection

@section('js')
  
@endsection