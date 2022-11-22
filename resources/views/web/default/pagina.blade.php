@extends("web.{$configuracoes->template}.master.master")

@section('content')
<section class="banner-tems text-center">
    <div class="container">
        <div class="banner-content">
            <h2 class="h2sombra">{{$post->titulo}}</h2>
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
                                {!!$post->content!!}
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <br />
                @if($post->images()->get()->count()) 
                    <div class="gallery-our wrap-gallery-restaurant gallery_1" style="padding-bottom:10px;">
                        <div class="container">
                            <div class="gallery gallery-restaurant">
                                <div class="tab-content">
                                    <div id="all" class="tab-pane fade in active">
                                        <div class="product ">
                                            <div class="row">                         
                                                @foreach($post->images()->get() as $key => $image)
                                                    <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                                        <div class="wrap-box-1">
                                                            <div class="box-img">
                                                                <a class="lightbox " href="{{ $image->url_image }}" data-littlelightbox-group="gallery" title="{{$post->titulo}}">
                                                                <img src="{{ $image->url_image }}" class="img img-responsive" alt="{{$post->titulo}}" title="{{$post->titulo}}"></a>
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
                @endif                                 
            </div>
        </div>
    </div>
</section>
@endsection

@section('css')
    <style>
        .img{
            width: 260px;
            height: 169px;
        }
    </style>
@endsection

@section('js')
    
@endsection