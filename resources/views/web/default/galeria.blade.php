@extends("web.{$configuracoes->template}.master.master")

@section('content')

    <section class="banner-tems text-center">
        <div class="container">
            <div class="banner-content">
                <h2 class="h2sombra">{{$galeria->titulo}}</h2>
                <p>&nbsp;</p>
            </div>
        </div>
    </section>

    @if ($galeria->images()->get()->count())
        <div class="gallery-our wrap-gallery-restaurant gallery_1" style="padding-bottom:10px;">
            <div class="container">
                <div class="gallery gallery-restaurant">
                    <div class="tab-content">
                        <div id="all" class="tab-pane fade in active">
                            <div class="product ">
                                <div class="row">
                                    @foreach ($galeria->images()->get() as $gb)
                                        <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                            <div class="wrap-box-1">
                                                <div class="box-img">
                                                    <a class="lightbox " href="{{ $gb->url_image }}" data-littlelightbox-group="gallery" title="{{$galeria->titulo}}">
                                                    <img src="{{ $gb->url_image }}" class="img img-responsive" alt="{{$galeria->titulo}}" title="{{$galeria->titulo}}"></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container"><br />
            <div class="alert alert-danger">
                Desculpe, não existem fotos cadastradas nessa Galeria :(
            </div>
        </div>
    @endif

@endsection

@section('css')
    <style>
        .img{
            width: 260px;
            height: 169px;
        }
    </style>
@endsection