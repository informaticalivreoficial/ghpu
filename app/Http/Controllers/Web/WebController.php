<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Web\Atendimento;
use App\Mail\Web\AtendimentoRetorno;
use Illuminate\Support\Facades\Storage;

use App\Models\{
    Post,
    CatPost,
    Cidades,
    Empresa,
    Estados,
    Galeria,
    PrevisaoTempo,
    User
};
use App\Services\CidadeService;
use App\Services\ConfigService;
use App\Services\EstadoService;
use App\Support\Seo;
use Carbon\Carbon;

class WebController extends Controller
{
    protected $configService, $estadoService, $cidadeService;
    protected $seo;

    public function __construct(
        ConfigService $configService, 
        EstadoService $estadoService)
    {
        $this->configService = $configService;
        $this->estadoService = $estadoService;
        $this->seo = new Seo();        
    }

    public function fetchCity(Request $request)
    {
        $data['cidades'] = Cidades::where("estado_id",$request->estado_id)->get(["cidade_nome", "cidade_id"]);
        return response()->json($data);
    }

    public function home()
    {
        $empresas = Empresa::orderBy('created_at', 'DESC')->available()->limit(4)->get();
        $boletim = new PrevisaoTempo('http://servicos.cptec.inpe.br/XML/cidade/5515/previsao.xml');
        
        $head = $this->seo->render($this->configService->getConfig()->nomedosite ?? 'Informática Livre',
            $this->configService->getConfig()->descricao ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.home'),
            $this->configService->getConfig()->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        ); 
        
		return view('web.'.$this->configService->getConfig()->template.'.home',[
            'head' => $head,   
            'empresas' => $empresas,
            'boletim' => $boletim->getContent(),
		]);
    }

    public function quemsomos()
    {
        $paginaQuemSomos = Post::where('tipo', 'pagina')->postson()->where('id', 5)->first();
        $head = $this->seo->render('Quem Somos - ' . $this->configService->getConfig()->nomedosite,
            $this->configService->getConfig()->descricao ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.quemsomos'),
            $this->configService->getConfig()->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        return view('web.'.$this->configService->getConfig()->template.'.quem-somos',[
            'head' => $head,
            'paginaQuemSomos' => $paginaQuemSomos
        ]);
    }

    public function politica()
    {
        $head = $this->seo->render('Política de Privacidade - ' . $this->configService->getConfig()->nomedosite ?? 'Informática Livre',
            'Política de Privacidade - ' . $this->configService->getConfig()->nomedosite,
            route('web.politica'),
            $this->configService->getConfig()->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$this->configService->getConfig()->template.'.politica',[
            'head' => $head
        ]);
    }

    public function artigo(Request $request)
    {
        $post = Post::where('slug', $request->slug)->postson()->first();
        
        $categorias = CatPost::orderBy('titulo', 'ASC')
            ->where('tipo', 'artigo')
            ->get();
        $postsMais = Post::orderBy('views', 'DESC')
            ->where('id', '!=', $post->id)
            ->where('tipo', 'artigo')
            ->limit(4)
            ->postson()
            ->get();
        $postsTags = Post::orderBy('views', 'DESC')
            ->where('tipo', 'artigo')
            ->where('tags', '!=', '')
            ->where('id', '!=', $post->id)
            ->postson()
            ->limit(11)
            ->get();
        
        $post->views = $post->views + 1;
        $post->save();

        $head = $this->seo->render($post->titulo ?? 'Informática Livre',
            $post->titulo,
            route('web.blog.artigo', ['slug' => $post->slug]),
            $post->cover() ?? $this->configService->getConfig()->getMetaImg()
        );

        return view('web.'.$this->configService->getConfig()->template.'.blog.artigo', [
            'head' => $head,
            'post' => $post,
            'postsMais' => $postsMais,
            'postsTags' => $postsTags,
            'categorias' => $categorias
        ]);
    }    

    public function pesquisa(Request $request)
    {
        $search = $request->only('search');

        $paginas = Post::where(function($query) use ($request){
            if($request->search){
                $query->orWhere('titulo', 'LIKE', "%{$request->search}%")
                    ->where('tipo', 'pagina')->postson();
                $query->orWhere('content', 'LIKE', "%{$request->search}%")
                    ->where('tipo', 'pagina')->postson();
            }
        })->postson()->limit(10)->get();

        $artigos = Post::where(function($query) use ($request){
            if($request->search){
                $query->orWhere('titulo', 'LIKE', "%{$request->search}%")
                    ->where('tipo', 'artigo')->postson();
                $query->orWhere('content', 'LIKE', "%{$request->search}%")
                    ->where('tipo', 'artigo')->postson();
            }
        })->postson()->limit(10)->get();
        
        $head = $this->seo->render('Pesquisa por ' . $request->search ?? 'Informática Livre',
            'Pesquisa - ' . $this->configService->getConfig()->nomedosite,
            route('web.blog.artigos'),
            $this->configService->getConfig()->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        
        return view('web.'.$this->configService->getConfig()->template.'.pesquisa',[
            'head' => $head,
            'paginas' => $paginas,
            'artigos' => $artigos
        ]);
    }

    public function pagina($slug)
    {
        $clientesCount = User::where('client', 1)->count();
        $post = Post::where('slug', $slug)->where('tipo', 'pagina')->postson()->first();        
        $post->views = $post->views + 1;
        $post->save();

        $head = $this->seo->render($post->titulo ?? 'Informática Livre',
            $post->titulo,
            route('web.pagina', ['slug' => $post->slug]),
            $post->cover() ?? $this->configService->getConfig()->getMetaImg()
        );

        return view('web.'.$this->configService->getConfig()->template.'.pagina', [
            'head' => $head,
            'post' => $post,
            'clientesCount' => $clientesCount
        ]);
    }    
    
    public function atendimento()
    {
        $head = $this->seo->render('Atendimento - ' . $this->configService->getConfig()->nomedosite,
            'Nossa equipe está pronta para melhor atender as demandas de nossos clientes!',
            route('web.atendimento'),
            $this->configService->getConfig()->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );        

        return view('web.'.$this->configService->getConfig()->template.'.atendimento', [
            'head' => $head            
        ]);
    }

    

    

    public function avaliacaoCliente(Request $request)
    {
        $head = $this->seo->render('Questionário de avaliação - ' . $this->configService->getConfig()->nomedosite,
            'Questionário de avaliação',
            route('web.avaliacao'),
            $this->configService->getConfig()->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$this->configService->getConfig()->template.'.cliente.avaliacao',[
            'head' => $head
        ]);
    }

    public function sitemap()
    {
        $url = $this->configService->getConfig()->sitemap;
        $data = file_get_contents($url);
        return response($data, 200, ['Content-Type' => 'application/xml']);
    }

    
    public function zapchat(Request $request)
    {
        $textoZap = $request->texto;
        $link = \App\Helpers\WhatsApp::getNumZap($this->configService->getConfig()->whatsapp, $textoZap);
        return redirect($link);
    }
}
