@extends('admin.maindesign')

@section('page_title', 'Agregar categoría')

@section('content')

    @if(session('category_message'))
        <div class="alert alert-success mb-3">
            {{ session('category_message') }}
        </div>
    @endif

    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <strong>Nueva categoría</strong>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.postaddcategory') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="category">Nombre de la categoría</label>
                        <input
                            type="text"
                            name="category"
                            id="category"
                            class="form-control"
                            placeholder="Ingresar categoría"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">
                        Agregar categoría
                    </button>
                </form>
            </div>
        </div>

    </div>

@endsection
