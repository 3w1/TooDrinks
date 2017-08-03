<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
