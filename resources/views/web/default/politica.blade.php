@extends("web.{$configuracoes->template}.master.master")

@section('content')
<section class="banner-tems text-center">
    <div class="container">
        <div class="banner-content">
            <h2 class="h2sombra">Política de Privacidade</h2>
            <p>&nbsp;</p>
        </div>
    </div>
</section>

<section class="section-about">
    <div class="container">
        <div class="row">
            <div class="wrap-about">               
                <div class="about-item" style="padding:10px;">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="text">
                            <div class="desc">
                                {!! $configuracoes->politicas_de_privacidade !!}
                            </div>
                        </div>
                    </div>
                </div>                                       
            </div>
        </div>
    </div>
</section>
@endsection