<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca; use App\Models\Producto;
use DB;

class FrontendController extends Controller
{
    public function index(){
        return view('frontend.inicio')->with(compact('paises', 'bebidas'));
    }

    public function noticias(){
    	return view('frontend.noticias');
    }

    public function quienes_somos(){
    	return view('frontend.quienesSomos');
    }

    public function contacto(){
    	return view('frontend.contacto');
    }

    public function marcas(){
    	$paises = DB::table('pais')
    			->orderBy('pais', 'ASC')
    			->pluck('pais', 'id');

    	$marcas = Marca::orderBy('nombre', 'ASC')
    			->where('id', '<>', 0)
    			->paginate(8);

    	return view('frontend.marcas')->with(compact('paises', 'marcas'));
    }

    public function detalle_marca($id){
    	$marca = Marca::where('id', '=', $id)->first();

    	$prod = DB::table('producto')
    					->select('id')
    					->where('marca_id', '=', $id)
    					->get();
    	$cont = 0;
    	foreach ($prod as $p){
    		$cont++;
    	}

    	$productos = Producto::orderBy('nombre', 'ASC')
    				->where('marca_id', '=', $id)
    				->take(3)
    				->get();

    	return view('frontend.detallesMarca')->with(compact('marca', 'productos', 'cont'));
    }

    public function productos(){
    	$paises = DB::table('pais')
    			->orderBy('pais', 'ASC')
    			->pluck('pais', 'id');

    	$bebidas = DB::table('bebida')
    			->orderBy('nombre', 'ASC')
    			->pluck('nombre', 'id');

   		$productos = Producto::orderBy('nombre', 'ASC')
    				->where('id', '<>', 0)
    				->paginate(12);

    	return view('frontend.productos')->with(compact('paises', 'bebidas', 'productos'));
    }

    public function detalle_producto($id){
    	$producto = Producto::where('id', '=', $id)->first();

    	$productos = Producto::orderBy('nombre', 'ASC')
    				->where('bebida_id', '=', $producto->bebida_id)
    				->where('clase_bebida_id', '=', $producto->clase_bebida_id)
    				->where('id', '<>', 0)
    				->where('id', '<>', $id)
    				->take(3)
    				->get();

    	return view('frontend.detallesProducto')->with(compact('producto', 'productos'));
    }
}
