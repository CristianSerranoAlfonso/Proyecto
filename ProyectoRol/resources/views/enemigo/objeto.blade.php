<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Añadir Objetos al enemigo: ') }} {{$entidad->nombre}}
        </h2> 
    </x-slot>
    @push('head')
	 <!-- Styles -->
	 <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
	 <!--Responsive Extension Datatables CSS-->
	 <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">

	  <!-- jQuery -->
	  <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	  <!-- Datatable.js -->
	  <script src="{{ asset('js/datatable.js') }}"></script>
	  <!--Datatables Responsive-->
	  <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
	  <style>
		
		/*Overrides for Tailwind CSS */
		
		/*Form fields*/
		.dataTables_wrapper select,
		.dataTables_wrapper .dataTables_filter input {
			color: #3DA0A9; 			/*text-gray-700*/
			padding-left: 1rem; 		/*pl-4*/
			padding-right: 1rem; 		/*pl-4*/
			padding-top: .5rem; 		/*pl-2*/
			padding-bottom: .5rem; 		/*pl-2*/
			margin-bottom: 3px;
			line-height: 1.25; 			/*leading-tight*/
			border-width: 2px; 			/*border-2*/
			border-radius: .25rem; 		
			border-color: #3DA0A9; 		/*border-gray-200*/
			background-color: #1B1B1B; 	/*bg-gray-200*/
		}

		/*Row Hover*/
		table.dataTable.hover tbody tr:hover, table.dataTable.display tbody tr:hover {
			background-color: #ebf4ff;	/*bg-indigo-100*/
		}
		
		/*Pagination Buttons*/
		.dataTables_wrapper .dataTables_paginate .paginate_button		{
			font-weight: 700;				/*font-bold*/
			border-radius: .25rem;			/*rounded*/
			border: 1px solid transparent;	/*border border-transparent*/
		}
		
		/*Pagination Buttons - Current selected */
		.dataTables_wrapper .dataTables_paginate .paginate_button.current	{
			color: #1B1B1B !important;				/*text-white*/
			box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06); 	/*shadow*/
			font-weight: 700;					/*font-bold*/
			border-radius: .25rem;				/*rounded*/
			background: #3DA0A9 !important;		/*bg-indigo-500*/
			border: 1px solid transparent;		/*border border-transparent*/
		}

		/*Pagination Buttons - Hover */
		.dataTables_wrapper .dataTables_paginate .paginate_button:hover		{
			color: #1B1B1B;				/*text-white*/
			box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);	 /*shadow*/
			font-weight: 700;					/*font-bold*/
			border-radius: .25rem;				/*rounded*/
			cursor: pointer;
			border: 1px solid transparent;		/*border border-transparent*/
		}
		
		/*Add padding to bottom border */
		table.dataTable.no-footer {
			border-bottom: 1px solid #e2e8f0;	/*border-b-1 border-gray-300*/
			margin-top: 0.75em;
			margin-bottom: 0.75em;
		}
		
		/*Change colour of responsive icon*/
		table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
			background-color: #667eea !important; /*bg-indigo-500*/
		}
		
      </style>
        <script>
            $(document).ready(function() {
			
			var table = $('#pjs').DataTable( {
					responsive: true
				})
				.columns.adjust()
				.responsive.recalc();
		    });

           
        </script>
    @endpush
    <div>
        {{$msj ?? ''}}
    </div>
	<form action="{{ route('enemigo.addobjeto', $entidad->id) }}" method="POST">
            @csrf 
            @method('PATCH')
        <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2 mt-3">
			<!--Card-->
			<div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-secundary1">
                    <table id="pjs" class="hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                        <thead>
                            <tr role="row">
                                <th data-priority="0"></th>
                                <th data-priority="1">Nombre</th>
                                <th data-priority="2">Rango</th>
                                <th data-priority="2">Tipo</th>
                                <th data-priority="3">Armadura</th>
                                <th data-priority="3">Fuerza</th>
                                <th data-priority="3">Destreza</th>
                                <th data-priority="3">Inteligencia</th>
                                <th data-priority="3">Cordura</th>
                                <th data-priority="3">Sabiduría</th>
                                <th data-priority="3">Evasión</th>
                                <th data-priority="3">Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($objetos as $objeto)
                                <tr role="row">
                                    <td tabindex="0" class="sorting_1" style><input type="checkbox" value="{{$objeto->id}}" name="{{$objeto->id}}" id="{{$entidad->id}}">
                                    <td class="text-center">{{$objeto->nombre}}</td>
                                    <td class="text-center">{{$objeto->rango}}</td>
                                    <td class="text-center">{{$objeto->tipo}}</td>
                                    <td class="text-center">{{$objeto->armadura}}</td>
                                    <td class="text-center">{{$objeto->fuerza}}</td>
                                    <td class="text-center">{{$objeto->destreza}}</td>
                                    <td class="text-center">{{$objeto->inteligencia}}</td>
                                    <td class="text-center">{{$objeto->cordura}}</td>
                                    <td class="text-center">{{$objeto->sabiduria}}</td>
                                    <td class="text-center">{{$objeto->evasion}}</td>
                                    <td class="text-center">{{$objeto->precio}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
			</div>
			<!--/Card-->
			@if(!empty($objetos))
				<input type="submit" style="cursor:pointer"class="w-full border border-black px-4 py-2 bg-primary text-black rounded-md hover:bg-primary2 hover:border-primary hover:text-primary text-center" value="Añadir" name="add">
			@endif
        </div>
    </form>
</x-app-layout>