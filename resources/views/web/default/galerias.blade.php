@extends("web.{$configuracoes->template}.master.master")

@section('content')

    <section class="banner-tems text-center">
        <div class="container">
            <div class="banner-content">
                <h2 class="h2sombra">Galerias</h2>
                <p>&nbsp;</p>
            </div>
        </div>
    </section>

    @if (!empty($galerias) && $galerias->count() > 0)
        <div class="gallery-our wrap-gallery-restaurant gallery_1">
            <div class="container">
                <div class="gallery gallery-restaurant">  
                        <ul class="nav nav-tabs text-uppercase">
                            @foreach ($galerias as $key => $item)
                                <li class="{{($key == 0 ? 'active' : '')}}">
                                    <a data-toggle="tab" href="#{{$item->id}}">{{$item->titulo}}</a>
                                </li>
                            @endforeach                   
                        </ul>
                    <br/>

                    <div class="tab-content">                    
                        @foreach ($galerias as $key => $galeria)
                            <div id="{{$galeria->id}}" class="tab-pane fade in {{($key == 0 ? 'active' : '')}}"> 
                                <div class="product "> 
                                    <div class="row">
                                        @if ($galeria->images()->get()->count())
                                            @foreach ($galeria->images()->get() as $gb)
                                                <div class="gallery_product col-lg-3 col-md-3 col-sm-6 col-xs-6 ">
                                                    <div class="wrap-box">
                                                        <div class="box-img">
                                                            <img src="{{ $gb->url_image }}" class="img img-responsive" alt="{{$galeria->titulo}}" title="{{$galeria->titulo}}">
                                                        </div>
                                                        <div class="gallery-box-main " title>
                                                            <div class="gallery-icon">
                                                                <a href="{{route('web.galeria',['slug' => $galeria->slug ])}}" title="{{$galeria->titulo}}"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div> 
                        @endforeach
                    </div>                    
                </div>                
            </div>            
        </div>
    @endif 

@endsection

@section('css')
    <style>
        .img{
            width: 260px !important;
            height: 169px !important;
        }
    </style>
@endsection