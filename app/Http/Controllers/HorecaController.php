<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horeca;
use App\Models\Pais;
use App\Models\Provincia_Region;
use App\Models\Telefono_Horeca;
use DB; use Storage; use Auth; use Input; use Image;


class HorecaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/horecas/';
        $path2 = public_path().'/imagenes/horecas/thumbnails/';
        $nombre = 'horeca_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $horeca = new Horeca($request->all());
        $horeca->logo = $nombre;
        $horeca->save();

        return redirect('usuario')->with('msj', 'Se ha registrado exitosamente su horeca');
    }

    public function show($id)
    {
        $horeca = Horeca::find($id);

        session(['horecaId' => $id]);
        session(['horecaNombre' => $horeca->nombre]);
        session(['horecaLogo' => $horeca->logo]);
        
        return view('horeca.show')->with(compact('horeca'));
    }

    public function edit($id)
    {
        $horeca = Horeca::find($id);

        $paises = DB::table('pais')
                        ->orderBy('pais')
                        ->pluck('pais', 'id');

        $provincias = DB::table('provincia_region')
                        ->orderBy('provincia')
                        ->where('pais_id', '=', $horeca->pais_id)
                        ->pluck('provincia', 'id');

        return view('horeca.edit')->with(compact('horeca', 'paises', 'provincias'));
    }

    public function update(Request $request, $id)
    {
        $horeca = Horeca::find($id);
        $horeca->fill($request->all());
        $horeca->save();

        $url = 'horeca/'.$id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    public function updateAvatar(Request $request){
        $file = Input::file('logo');   
        $image = Image::make(Input::file('logo'));

        $path = public_path().'/imagenes/horecas/';
        $path2 = public_path().'/imagenes/horecas/thumbnails/';
        $nombre = 'horeca_'.time().'.'.$file->getClientOriginalExtension();

        $image->save($path.$nombre);
        $image->resize(240,200);
        $image->save($path2.$nombre);

        $actualizacion = DB::table('horeca')
                            ->where('id', '=', $request->id)
                            ->update(['logo' => $nombre ]);
       
       $url = 'horeca/'.$request->id.'/edit';
       return redirect($url)->with('msj', 'Su imagen de perfil ha sido cambiada con éxito');
    }

    public function destroy($id)
    {

    }

    public function listado_ofertas(){
        $horeca = DB::table('horeca')
                            ->where('id', '=', session('horecaId') )
                            ->select('provincia_region_id')
                            ->get()
                            ->first();

        $ofertas = DB::table('oferta')
                    ->select('oferta.*')
                    ->join('destino_oferta', 'oferta.id', '=', 'destino_oferta.oferta_id')
                    ->where('oferta.visible_horecas', '=', '1')
                    ->where('destino_oferta.provincia_region_id', '=', $horeca->provincia_region_id)
                    ->paginate(6);

        return view('horeca.listados.ofertasDisponibles')->with(compact('ofertas'));
    }
}
