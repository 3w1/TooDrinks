@extends('frontend.plantillas.main')

@section('content')

	 	<!-- SLIDER PRINCIPAL -->
        @include('frontend.plantillas.partes.slider')
        <!-- FIN DEL SLIDER PRINCIPAL -->

        <section id="content">
            <!-- PANEL DE BÚSQUEDA -->
            @include('frontend.plantillas.partes.searchTabs')
            <!-- FIN DE PANEL DE BÚSQUEDA -->

            <div class="container section">
                <h2>Noticias Recientes</h2>
                <!-- SLIDER DE NOTICIAS RECIENTES -->
                @include('frontend.plantillas.partes.noticias')
                <!-- FIN DE SLIDER DE NOTICIAS RECIENTES -->
                
                <br><hr />

                <!-- SECCIÓN DE ICONOS -->
                @include('frontend.plantillas.partes.iconos')
                <!-- FIN DE SECCIÓN DE ICONOS -->
            </div>
        </section>
@endsection