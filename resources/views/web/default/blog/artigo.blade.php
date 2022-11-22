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
<!-- BLOG -->
<div class="section-blog blog-detail">
    <div class="container">
        <div class="blog">
            <div class="row">
                <div class=" col-lg-12 col-md-12">
                    <div class="blog-content">
                        <!-- POST SINGLE -->
                        <article class="post post-single">
                            <div class="entry-media ">
                                <a href="#" title="" class="hover-zoom-1">
                                    <img src="{{$post->cover()}}" alt="{{$post->titulo}}"/>
                                </a>                                    
                            </div>
                            <div class="entry-header">
                                <h2 class="entry-title">{{$post->titulo}}</h2>                                    
                            </div>
                            <div class="entry-content">
                                {!!$post->content!!}
                            </div>
                        </article>
                        <!-- END / POST SINGLE -->
                        <div class="share-tag">
                            <div class="shareInner">
                                <!-- Social list -->
                                <div id="shareIcons"></div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="sidebar">
                        @if (!empty($postsMais) && $postsMais->count() > 0)
                            <div class="widget widget_recent_entries ">
                                <h4 class="widget-title">Veja Também</h4>
                                <ul>
                                    @foreach ($postsMais as $postmais)
                                        <li>
                                            <div class="img">
                                            <a href="{{route(($postmais->tipo == 'artigo' ? 'web.blog.artigo' : 'web.noticia'), ['slug' => $postmais->slug] )}}">
                                                <img src="{{$postmais->cover()}}" alt="'.$mais['titulo'].'">
                                            </a>
                                            </div>
                                            <div class="text">
                                                <a href="{{route(($postmais->tipo == 'artigo' ? 'web.blog.artigo' : 'web.noticia'), ['slug' => $postmais->slug] )}}">{{$postmais->titulo}}</a>
                                                <span class="date">{{ Carbon\Carbon::parse($postmais->created_at)->format('d/m/Y') }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>                        
                        @endif                        
                    </div> 
                </div>
                   <div class="col-lg-6 col-md-6">    
                    <div class="sidebar">  
                        @if(!empty($postsTags) && $postsTags->count() > 0) 
                            <div class="widget widget_tag_cloud">
                                <h4 class="widget-title">Tags</h4>
                                <div class="tagcloud">
                                    @foreach($postsTags as $posttags) 
                                        @php
                                            $array = explode(",", $posttags->tags);
                                            foreach($array as $tags){
                                                $tag = trim($tags);                                                       
                                                echo '<a href="'.route('web.blog.artigo',['slug' => $posttags->slug]).'">';    
                                                echo $tag;
                                                echo '</a>';
                                            }
                                        @endphp                                                                        
                                    @endforeach
                                </div>
                            </div>
                        @endif 
                        
                        <div class="widget widget_social">
                            <h4 class="widget-title">Redes Sociais</h4>
                            <div class="widget-social">
                                @if ($configuracoes->facebook)
									<a target="_blank" href="{{$configuracoes->facebook}}" title="Facebook"><i class="fa fa-facebook"></i></a>
								@endif
								@if ($configuracoes->twitter)
									<a target="_blank" href="{{$configuracoes->twitter}}" title="Twitter"><i class="fa fa-twitter"></i></a>
								@endif
								@if ($configuracoes->instagram)
									<a target="_blank" href="{{$configuracoes->instagram}}" title="Instagram"><i class="fa fa-instagram"></i></a>
								@endif
								@if ($configuracoes->linkedin)
									<a target="_blank" href="{{$configuracoes->linkedin}}" title="linkedin"><i class="fa fa-linkedin"></i></a>
								@endif                                                                   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('frontend/'.$configuracoes->template.'/assets/js/jsSocials/jssocials.css')}}" />
    <link rel="stylesheet" href="{{url('frontend/'.$configuracoes->template.'/assets/js/jsSocials/jssocials-theme-flat.css')}}" />
@endsection

@section('js')
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/jsSocials/jssocials.min.js')}}"></script>
    <script>
        (function ($) {
            
            $('#shareIcons').jsSocials({
                //url: "http://www.google.com",
                showLabel: false,
                showCount: false,
                shareIn: "popup",
                shares: ["email", "twitter", "facebook", "whatsapp"]
            });
            $('.shareIcons').jsSocials({
                //url: "http://www.google.com",
                showLabel: false,
                showCount: false,
                shareIn: "popup",
                shares: ["email", "twitter", "facebook", "whatsapp"]
            });  
        
        })(jQuery); 
    </script>    
@endsection