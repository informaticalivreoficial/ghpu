<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GaleriaRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Galeria;
use App\Models\GaleriaGb;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GaleriaController extends Controller
{
    public function index()
    {
        $galerias = Galeria::orderBy('status', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->paginate(25);
        return view('admin.galerias.index', [
            'galerias' => $galerias
        ]);
    }

    public function create()
    {
        $galerias = Galeria::orderBy('titulo', 'ASC')->get();
        return view('admin.galerias.create',[
            'galerias' => $galerias
        ]);
    }

    public function store(GaleriaRequest $request)
    {
        $criarGaleria = Galeria::create($request->all());
        $criarGaleria->fill($request->all());
        $criarGaleria->setSlug();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return redirect()->back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.',
            ]);
        }
        
        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $galeriaGb = new GaleriaGb();
                $galeriaGb->galeria = $criarGaleria->id;
                $galeriaGb->path = $image->storeAs(env('AWS_PASTA') . 'galerias/' . $criarGaleria->id, Str::slug($request->titulo) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                $galeriaGb->save();
                unset($galeriaGb);
            }
        }
        return redirect()->route('galerias.edit', [
            'id' => $criarGaleria->id,
        ])->with(['color' => 'success', 'message' => 'Galeria cadastrada com sucesso!']);
    }

    public function edit($id)
    {
        $editarGaleria = Galeria::where('id', $id)->first();                
        return view('admin.galerias.edit', [
            'galeria' => $editarGaleria,            
        ]);
    }

    public function update(GaleriaRequest $request, $id)
    {
        $galeriaUpdate = Galeria::where('id', $id)->first();
        $galeriaUpdate->fill($request->all());
        $galeriaUpdate->save();
        $galeriaUpdate->setSlug();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return redirect()->back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.',
            ]);
        }

        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $galeriaGb = new GaleriaGb();
                $galeriaGb->galeria = $galeriaUpdate->id;
                $galeriaGb->path = $image->storeAs(env('AWS_PASTA') . 'galerias/' . $galeriaUpdate->id, Str::slug($request->titulo) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                $galeriaGb->save();
                unset($galeriaGb);
            }
        }

        return redirect()->route('galerias.edit', [
            'id' => $galeriaUpdate->id,
        ])->with(['color' => 'success', 'message' => 'Galeria atualizada com sucesso!']);
    }

    public function galeriaSetStatus(Request $request)
    {        
        $galeria = Galeria::find($request->id);
        $galeria->status = $request->status;
        $galeria->save();
        return response()->json(['success' => true]);
    }

    public function imageRemove(Request $request)
    {
        $imageDelete = GaleriaGb::where('id', $request->image)->first();
        Storage::delete($imageDelete->path);
        $imageDelete->delete();
        $json = [
            'success' => true,
        ];
        return response()->json($json);
    }

    public function imageSetCover(Request $request)
    {
        $imageSetCover = GaleriaGb::where('id', $request->image)->first();
        $allImage = GaleriaGb::where('galeria', $imageSetCover->galeria)->get();
        foreach ($allImage as $image) {
            $image->cover = null;
            $image->save();
        }
        $imageSetCover->cover = true;
        $imageSetCover->save();
        $json = [
            'success' => true,
        ];
        return response()->json($json);
    }

    public function delete(Request $request)
    {
        $postdelete = Galeria::where('id', $request->id)->first();
        $postGb = GaleriaGb::where('galeria', $postdelete->id)->first();
        $nome = \App\Helpers\Renato::getPrimeiroNome(Auth::user()->name);

        if(!empty($postdelete)){
            if(!empty($postGb)){
                $json = "<b>$nome</b> você tem certeza que deseja excluir a galeria? Existem imagens adicionadas e todas serão excluídas!";
                return response()->json(['error' => $json,'id' => $postdelete->id]);
            }else{
                $json = "<b>$nome</b> você tem certeza que deseja excluir esta galeria?";
                return response()->json(['error' => $json,'id' => $postdelete->id]);
            }            
        }else{
            return response()->json(['error' => 'Erro ao excluir']);
        }
    }
    
    public function deleteon(Request $request)
    {
        $postdelete = Galeria::where('id', $request->galeria_id)->first();  
        $imageDelete = GaleriaGb::where('galeria', $postdelete->id)->first();
        $postR = $postdelete->titulo;

        if(!empty($postdelete)){
            if(!empty($imageDelete)){
                Storage::delete($imageDelete->path);
                $imageDelete->delete();
                Storage::deleteDirectory('galerias/'.$postdelete->id);
                $postdelete->delete();
            }
            $postdelete->delete();
        }
        return redirect()->route('galerias.index')->with([
            'color' => 'success', 
            'message' => 'Galeria foi removida com sucesso!'
        ]);
    }
}
