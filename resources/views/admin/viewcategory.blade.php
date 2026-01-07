@extends('admin.maindesign')

@section('page_title', 'Categorías')

@section('content')

@if(session('deletecategory_message'))
    <div class="alert alert-danger mb-3">
        {{ session('deletecategory_message') }}
    </div>
@endif

<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <strong>Listado de categorías</strong>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->category }}</td>
                            <td>
                                <a href="{{ route('admin.categoryupdate', $category->id) }}"
                                   class="btn btn-sm btn-warning">
                                    Editar
                                </a>

                                <a href="{{ route('admin.categorydelete', $category->id) }}"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('¿Confirma borrar categoría?')">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection
