<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AdminController,
    AuthController,
    UserController,
    EmailController,
    PostController,
    CatPostController,
    ComentarioOcorrenciaController,
    ConfigController,
    EmpresaController,
    MenuController,
    MsgUserController,
    NotificationController,
    OcorrenciaController,
    SitemapController,
};
use App\Http\Controllers\Admin\ACL\PermissionController;
use App\Http\Controllers\Admin\ACL\RoleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Web\RssFeedController;
use App\Http\Controllers\Web\SendEmailController;
use App\Http\Controllers\Web\WebController;

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {

    /** Página Inicial */
    Route::get('/', [WebController::class, 'home'])->name('home');
    Route::match(['post', 'get'], '/fetchCity', [WebController::class, 'fetchCity'])->name('fetchCity');

    //**************************** Emails ********************************************/
    Route::get('/atendimento', [WebController::class, 'atendimento'])->name('atendimento');
    Route::get('/sendEmail', [SendEmailController::class, 'sendEmail'])->name('sendEmail');
    
    //****************************** Blog ***********************************************/
    Route::get('/blog/artigo/{slug}', [WebController::class, 'artigo'])->name('blog.artigo');
    Route::get('/blog/categoria/{slug}', [WebController::class, 'categoria'])->name('blog.categoria');
    Route::get('/blog', [WebController::class, 'artigos'])->name('blog.artigos');
    Route::match(['post', 'get'], '/blog/pesquisar', [WebController::class, 'searchBlog'])->name('blog.searchBlog');

    //*************************************** Páginas *******************************************/
    Route::get('/pagina/{slug}', [WebController::class, 'pagina'])->name('pagina');
    Route::get('/noticia/{slug}', [WebController::class, 'noticia'])->name('noticia');
    Route::get('/noticias', [WebController::class, 'noticias'])->name('noticias');
    Route::get('/noticias/categoria/{slug}', [WebController::class, 'categoria'])->name('noticia.categoria');
   
    //** Pesquisa */
    Route::match(['post', 'get'], '/pesquisa', [WebController::class, 'pesquisa'])->name('pesquisa');
    
    /** FEED */
    Route::get('feed', [RssFeedController::class, 'feed'])->name('feed');
    Route::get('/politica-de-privacidade', [WebController::class, 'politica'])->name('politica');
    Route::get('/sitemap', [WebController::class, 'sitemap'])->name('sitemap');

});

Route::prefix('admin')->middleware('auth')->group( function(){

    //******************** Sitemap *********************************************/
    Route::get('gerarxml', [SitemapController::class, 'gerarxml'])->name('admin.gerarxml');

    //******************** Configurações ***************************************/
    Route::match(['post', 'get'], 'configuracoes/fetchCity', [ConfigController::class, 'fetchCity'])->name('configuracoes.fetchCity');
    Route::put('configuracoes/{config}', [ConfigController::class, 'update'])->name('configuracoes.update');
    Route::get('configuracoes', [ConfigController::class, 'editar'])->name('configuracoes.editar');

    //********************* Categorias para Posts *******************************/
    Route::get('categorias/delete', [CatPostController::class, 'delete'])->name('categorias.delete');
    Route::delete('categorias/deleteon', [CatPostController::class, 'deleteon'])->name('categorias.deleteon');
    Route::put('categorias/posts/{id}', [CatPostController::class, 'update'])->name('categorias.update');
    Route::get('categorias/{id}/edit', [CatPostController::class, 'edit'])->name('categorias.edit');
    Route::match(['post', 'get'],'posts/categorias/create/{catpai}', [CatPostController::class, 'create'])->name('categorias.create');
    Route::post('posts/categorias/store', [CatPostController::class, 'store'])->name('categorias.store');
    Route::get('posts/categorias', [CatPostController::class, 'index'])->name('categorias.index');

    //********************** Blog ************************************************/
    Route::get('posts/set-status', [PostController::class, 'postSetStatus'])->name('posts.postSetStatus');
    Route::get('posts/set-menu', [PostController::class, 'postSetMenu'])->name('posts.postSetMenu');
    Route::get('posts/delete', [PostController::class, 'delete'])->name('posts.delete');
    Route::delete('posts/deleteon', [PostController::class, 'deleteon'])->name('posts.deleteon');
    Route::post('posts/image-set-cover', [PostController::class, 'imageSetCover'])->name('posts.imageSetCover');
    Route::delete('posts/image-remove', [PostController::class, 'imageRemove'])->name('posts.imageRemove');
    Route::put('posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::post('posts/categoriaList', [PostController::class, 'categoriaList'])->name('posts.categoriaList');
    Route::get('posts/artigos', [PostController::class, 'index'])->name('posts.artigos');
    Route::get('posts/noticias', [PostController::class, 'index'])->name('posts.noticias');
    Route::get('posts/paginas', [PostController::class, 'index'])->name('posts.paginas');

    //*********************** Email **********************************************/
    Route::get('email/suporte', [EmailController::class, 'suporte'])->name('email.suporte');
    Route::match(['post', 'get'], 'email/enviar-email', [EmailController::class, 'send'])->name('email.send');
    Route::post('email/sendEmail', [EmailController::class, 'sendEmail'])->name('email.sendEmail');
    Route::match(['post', 'get'], 'email/success', [EmailController::class, 'success'])->name('email.success');

    //*********************** Usuários *******************************************/
    Route::match(['get', 'post'], 'usuarios/pesquisa', [UserController::class, 'search'])->name('users.search');
    Route::match(['post', 'get'], 'usuarios/fetchCity', [UserController::class, 'fetchCity'])->name('users.fetchCity');
    Route::delete('usuarios/deleteon', [UserController::class, 'deleteon'])->name('users.deleteon');
    Route::get('usuarios/set-status', [UserController::class, 'userSetStatus'])->name('users.userSetStatus');
    Route::get('usuarios/delete', [UserController::class, 'delete'])->name('users.delete');
    Route::get('usuarios/time', [UserController::class, 'team'])->name('users.team');
    Route::get('usuarios/view/{id}', [UserController::class, 'show'])->name('users.view');
    Route::put('usuarios/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('usuarios/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('usuarios/create', [UserController::class, 'create'])->name('users.create');
    Route::post('usuarios/store', [UserController::class, 'store'])->name('users.store');
    Route::get('usuarios', [UserController::class, 'index'])->name('users.index');

    //****************************** Empresas *******************************************/
    Route::match(['post', 'get'], 'empresas/fetchCity', [EmpresaController::class, 'fetchCity'])->name('empresas.fetchCity');
    Route::get('empresas/set-status', [EmpresaController::class, 'empresaSetStatus'])->name('empresas.empresaSetStatus');
    Route::delete('empresas/deleteon', [EmpresaController::class, 'deleteon'])->name('empresas.deleteon');
    Route::get('empresas/delete', [EmpresaController::class, 'delete'])->name('empresas.delete');
    Route::put('empresas/{id}', [EmpresaController::class, 'update'])->name('empresas.update');
    Route::get('empresas/{id}/edit', [EmpresaController::class, 'edit'])->name('empresas.edit');
    Route::get('empresas/create', [EmpresaController::class, 'create'])->name('empresas.create');
    Route::post('empresas/store', [EmpresaController::class, 'store'])->name('empresas.store');
    Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas.index');

    //****************************** Ocorrências *******************************************/
    Route::any('ocorrencias/pesquisar', [OcorrenciaController::class, 'searchOcorrencias'])->name('ocorrencias.search');
    Route::get('ocorrencias/set-status', [OcorrenciaController::class, 'setStatus'])->name('ocorrencias.setStatus');
    Route::delete('ocorrencias/deleteon', [OcorrenciaController::class, 'deleteon'])->name('ocorrencias.deleteon');
    Route::get('ocorrencias/delete', [OcorrenciaController::class, 'delete'])->name('ocorrencias.delete');
    Route::put('ocorrencias/{id}', [OcorrenciaController::class, 'update'])->name('ocorrencias.update');
    Route::get('ocorrencias/{id}/edit', [OcorrenciaController::class, 'edit'])->name('ocorrencias.edit');
    Route::get('ocorrencias/cadastrar', [OcorrenciaController::class, 'create'])->name('ocorrencias.create');
    Route::post('ocorrencias/store', [OcorrenciaController::class, 'store'])->name('ocorrencias.store');
    Route::get('/ocorrencias', [OcorrenciaController::class, 'index'])->name('ocorrencias.index');
    Route::get('ocorrencias/empresa/{empresa}/view', [OcorrenciaController::class, 'ocorrencias'])->name('ocorrencias.view');
    Route::get('ocorrencias/{ocorrencia}/view', [OcorrenciaController::class, 'view'])->name('ocorrencia.view');
    
    //****************************** Modelos *******************************************/
    Route::get('ocorrencias/modelos/set-status', [OcorrenciaController::class, 'modeloSetStatus'])->name('modelos.modeloSetStatus');
    Route::delete('ocorrencias/modelos/deleteon', [OcorrenciaController::class, 'modeloDeleteon'])->name('modelos.deleteon');
    Route::get('ocorrencias/modelos/delete', [OcorrenciaController::class, 'modeloDelete'])->name('modelos.delete');
    Route::put('ocorrencias/modelos/{id}', [OcorrenciaController::class, 'modelosUpdate'])->name('modelos.update');
    Route::get('ocorrencias/modelos/{id}/edit', [OcorrenciaController::class, 'modelosEdit'])->name('modelos.edit');
    Route::get('ocorrencias/modelos/cadastrar', [OcorrenciaController::class, 'modelosCreate'])->name('modelos.create');
    Route::post('ocorrencias/modelos/store', [OcorrenciaController::class, 'modelosStore'])->name('modelos.store');
    Route::get('/ocorrencias/modelos', [OcorrenciaController::class, 'modelos'])->name('modelos.index');
    Route::match(['post', 'get'], '/ocorrencias/modelos/response', [OcorrenciaController::class, 'modelosResponse'])->name('modelos.response');

    //****************************** Menu *******************************************/
    Route::get('menus/set-status', [MenuController::class, 'menuSetStatus'])->name('menus.menuSetStatus');
    Route::delete('menus/deleteon', [MenuController::class, 'deleteon'])->name('menus.deleteon');
    Route::get('menus/delete', [MenuController::class, 'delete'])->name('menus.delete');
    Route::put('menus/{id}', [MenuController::class, 'update'])->name('menus.update');
    Route::get('menus/{id}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::get('menus/create', [MenuController::class, 'create'])->name('menus.create');
    Route::post('menus/store', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');    

    /** Permissões */
    Route::get('permission/delete', [PermissionController::class, 'delete'])->name('permission.delete');
    Route::delete('permission/deleteon', [PermissionController::class, 'deleteon'])->name('permission.deleteon');
    Route::resource('permission', PermissionController::class);

    /** Perfis */
    Route::get('role/delete', [RoleController::class, 'delete'])->name('role.delete');
    Route::delete('role/deleteon', [RoleController::class, 'deleteon'])->name('role.deleteon');
    Route::get('role/{role}/permissions', [RoleController::class, 'permissions'])->name('role.permissions');
    Route::put('role/{role}/permission/sync', [RoleController::class, 'permissionsSync'])->name('role.permissionsSync');
    Route::resource('role', RoleController::class); 

    //******************** Sitemap *********************************************/
    Route::get('gerarxml', [SitemapController::class, 'gerarxml'])->name('gerarxml');

    //Colaboradores
    Route::get('/', [AdminController::class, 'home'])->name('home');
    Route::get('/mensagens', [MsgUserController::class, 'index'])->name('mensagens.index');
    Route::get('/sendUserMsg', [MsgUserController::class, 'sendUserMsg'])->name('sendUserMsg');
    Route::get('colaborador/view/{id}', [UserController::class, 'showColaborador'])->name('users.view-colaborador');
    Route::get('/colaborador', [AdminController::class, 'colaborador'])->name('colaborador');
    Route::any('/colaborador/pesquisa', [OcorrenciaController::class, 'searchOcorrenciasColaborador'])->name('ocorrencias.search.colaborador');
    Route::post('/sendComment', [ComentarioOcorrenciaController::class, 'sendComment'])->name('sendComment');
    Route::post('/sendResposta', [MsgUserController::class, 'sendResposta'])->name('sendResposta');
    Route::get('/loadResposta', [MsgUserController::class, 'loadResposta'])->name('loadResposta');
    Route::get('msg/set-status', [MsgUserController::class, 'msgSetStatus'])->name('msgSetStatus');
    Route::post('/commentCount', [ComentarioOcorrenciaController::class, 'ocorrenciaCount'])->name('ocorrenciaCount');
    Route::get('/ocorrenciaView', [OcorrenciaController::class, 'ocorrenciaView'])->name('ocorrenciaView');
    Route::get('/loadComentarios', [ComentarioOcorrenciaController::class, 'loadComentarios'])->name('loadComentarios');
    
    Route::get('/notifications', [NotificationController::class, 'notifications'])->name('notifications');
    Route::put('/notification-all-read', [NotificationController::class, 'markAllAsRead']);
    Route::put('/notification-read', [NotificationController::class, 'markAsRead']);

});

Route::post('/loginrg', [AuthController::class, 'loginRg'])->name('login.do');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Auth::routes();
