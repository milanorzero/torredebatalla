@extends('admin.maindesign')

@section('page_title', 'Actualizar categoría')

@section('content')

    @if(session('category_updated_message'))
        <div class="alert alert-success mb-3">
            {{ session('category_updated_message') }}
        </div>
    @endif

    <div class="container-fluid">

        <div class="card w-100">
            <div class="card-header">
                <strong>Actualizar categoría</strong>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.postupdatecategory', $category->id) }}"
                      method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label>Nombre de la categoría</label>
                        <input type="text"
                               name="category"
                               value="{{ $category->category }}"
                               class="form-control"
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Actualizar categoría
                    </button>

                    <a href="{{ route('admin.viewcategory') }}"
                       class="btn btn-secondary ms-2">
                        Volver
                    </a>
                </form>
            </div>
        </div>

    </div>

@endsection
