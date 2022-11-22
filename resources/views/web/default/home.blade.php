@extends("web.{$configuracoes->template}.master.master")

@section('content')
<!-- SLIDER -->
<section class="section-slider height-v">

    <!-- Slider Section -->
    
    <div id="index12" class="owl-carousel  owl-theme">       
            
        
        @if (!empty($slides) && $slides->count() > 0)
            @foreach ($slides as $key => $slide)  
                <div class="item{{($key == 0 ? ' active' : '')}}">
                    @if ($slide->link != null)                        
                        <a href="{{$slide->link}}" {{($slide->target == 1 ? 'target="_blank"' : '')}}>
                            <img src="{{$slide->getimagem()}}" alt="{{$slide->titulo}}" />  
                        </a> 
                    @else
                        <img src="{{$slide->getimagem()}}" alt="{{$slide->titulo}}" />
                    @endif                         
                </div>
            @endforeach             
        @endif   
    </div>
    
    <!-- Slider Section /- -->
            
        {{--
        <form action="" method="post">
        <div class="check-avail">
                <div class="container">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        
                    </div>  
                </div>
            <div class="container">
                          
                <div class="arrival date-title ">
                    <label>Check In</label>
                    <div id="datepicker" class="input-group date" data-date-format="dd/mm/yyyy">
                        <input class="form-control" name="checkini" type="text" value=""/>
                        <span class="input-group-addon"><img src="{{url('frontend/'.$configuracoes->template.'/assets/images/date-icon.png')}}" alt="Check in"/></span>
                    </div>
                </div>
                <div class="departure date-title ">
                    <label>Check Out</label>
                    <div id="datepickeri" class="input-group date" data-date-format="dd/mm/yyyy">
                        <input class="form-control" name="checkouti" type="text" value=""/>
                        <span class="input-group-addon"><img src="{{url('frontend/'.$configuracoes->template.'/assets/images/date-icon.png')}}" alt="Check out"/></span>
                    </div>
                </div>
                <div class="adults date-title ">
                    <label>Adultos</label>                
                    <div class=" carousel-search">
                        <select name="adultos" class="selectindex">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    
                </div>
                <div class="children date-title ">
                    <label>Crianças 0 a 5</label>                
                    <div class=" carousel-search">
                        <select name="cri_0_5" class="selectindex">
                                <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>                    
                </div>
                <div class="find_btn date-title">
                    <button type="submit" name="SendReserva" class="text-find center btnindex">Reservar<br />Agora</button>                
                </div>
            </div>
        </div>
        </form>--}}
    </section>
    <!-- END / SLIDER -->

    @if (!empty($apartamentos) && $apartamentos->count() > 0)
        <section class="rooms">
            <div class="container">
                <h2 class="title-room">Apartamentos</h2>
                <div class="outline"></div>
                <p class="rooms-p">&nbsp;</p>
                <div class="wrap-rooms">
                    <div class="row">
                        <div id="rooms" class="owl-carousel owl-theme">                        
                            <div class="item">
                                @foreach($apartamentos as $apartamento)
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                        <div class="wrap-box" style="min-height: 400px;">
                                            <div class="box-img">
                                                <img style="max-height: 255px !important;" src="{{$apartamento->cover()}}" class="img-responsive" alt="{{$apartamento->titulo}}" title="{{$apartamento->titulo}}">       
                                            </div>
                                            <div class="rooms-content">
                                                <h4 class="">{{$apartamento->titulo}}</h4>
                                                <p class="price">
                                                    <a href="{{route('web.acomodacao', ['slug' => $apartamento->slug])}}">+ Detalhes</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    
	@if($configuracoes->descricao && $configuracoes->metaimg != null)    
        <section class="about">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                        <div class="about-centent">
                            <h2 class="about-title">{{$configuracoes->nomedosite}}</h2>
                            <div class="line"></div>
                            <p class="about-p">{{$configuracoes->descricao}}</p>                    
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-7 col-lg-7 ">
                        <div class="about-img">
                            <div class="img-1">
                                <img src="{{$configuracoes->getmetaimg()}}" class="img-responsive" alt="{{$configuracoes->nomedosite}}"/>                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>    
    @endif

    @if (!empty($artigos) && $artigos->count() > 0)
        <section class="events">
            <div class="container">
                <h2 class="events-title">Blog</h2>
                <div class="line"></div>
                <div id="events-v2" class="owl-carousel owl-theme">
                    @foreach($artigos as $artigo)
                        <div class="item ">
                            <div class="events-item">
                                <div class="events-img">
                                    <img src="{{$artigo->cover()}}" class="imgblog img-responsive" alt="{{$artigo->titulo}}">
                                </div>
                                <div class="events-content">
                                    <a href="{{route('web.blog.artigo', ['slug' => $artigo->slug])}}" title="{{$artigo->titulo}}">
                                        <h3 class="sky-h3">{{$artigo->titulo}}</h3>
                                        <p class="sky-p">Leia +</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="gallery-our" style="padding-top: 80px;">
        <div class="container-fluid">
            <iframe src="https://www.google.com/maps/embed?pb=!1m0!3m2!1spt-BR!2sbr!4v1488893723237!6m8!1m7!1sF%3A-hNOO3QBnDs4%2FWJtai4KscMI%2FAAAAAAAAEJs%2FB_Qh4lC_tTAGJL50IBdEP-e3tWMjIMveQCLIB!2m2!1d-23.43332223874241!2d-45.07221445441246!3f150.19085246815183!4f-0.20905841325189556!5f0.7820865974627469" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" style="border:0;width: 80%;" height="450" allowfullscreen></iframe>
        </div>
    </section>

    @if (!empty($galerias) && $galerias->count() > 0)
        <section class="gallery-our">
            <div class="container-fluid">
                <div class="gallery">
                    <h2 class="title-gallery">Fotos</h2>
                    <div class="outline"></div>                    
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
                                        @php
                                            $i = 1;
                                        @endphp
                                            @foreach ($galeria->images()->get() as $gb)
                                                @if ($i <= 8)
                                                    <div class="gallery_product col-lg-3 col-md-3 col-sm-6 col-xs-6 ">
                                                        <div class="wrap-box">
                                                            <div class="box-img">
                                                                <img src="{{ $gb->url_image }}" class="img img-responsive" alt="{{$galeria->titulo}}" title="{{$galeria->titulo}}">
                                                            </div>
                                                            <div class="gallery-box-main ">
                                                                <div class="gallery-icon">
                                                                    <a href="{{route('web.galeria',['slug' => $galeria->slug ])}}" title="{{$galeria->titulo}}"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif                                                
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        @endif
                                    </div> 
                                </div> 
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="text-center">
                        <a href="{{route('web.galerias')}}"><button type="button" class="btn btn-default btn-our">VER MAIS FOTOS</button></a>
                    </div>
                </div>
                
            </div>
        
        </section>
    @endif

@endsection

@section('css')
    <style>
        .img{
            width: 260px !important;
            height: 169px !important;
        }
        .imgblog{
            width: 370px !important;
            height: 500px !important;
        }
    </style>
@endsection

@section('js')
  
@endsection