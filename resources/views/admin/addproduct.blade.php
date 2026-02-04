@extends('admin.maindesign')

@section('page_title', 'Agregar producto')

@section('content')


    @if(session('product_message'))
        <div class="alert alert-success mb-3">
            {{ session('product_message') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-fluid">

        <div class="card w-100">
            <div class="card-header">
                <strong>Nuevo producto</strong>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.postaddproduct') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-3">
                        <label>Nombre del producto</label>
                        <input type="text"
                               name="product_title"
                               class="form-control"
                               required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Descripción</label>
                        <textarea name="product_description"
                                  class="form-control"
                                  rows="4"
                                  required></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Cantidad</label>
                        <input type="number"
                               name="product_quantity"
                               class="form-control"
                               required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Precio</label>
                        <input type="number"
                               name="product_price"
                               class="form-control"
                               required>
                    </div>

                    <div class="form-group mb-3">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_tournament"
                                   value="1"
                                   id="is_tournament">
                            <label class="form-check-label" for="is_tournament">
                                Es torneo (cupo)
                            </label>
                            <small class="text-muted d-block">
                                Si marcas esto, el stock se tratar\u00e1 como cupos.
                            </small>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>Imagen</label>
                        <input type="file"
                               name="product_image"
                               class="form-control">
                    </div>

                    <div class="form-group mb-4">
                        <label>Categoría</label>
                        <select name="product_category"
                                class="form-control"
                                required>
                            @foreach($categories as $category)
                                <option value="{{ $category->category }}">
                                    {{ $category->category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
    <label>Dónde se vende</label>
    <select name="sale_channel" class="form-control" required>
        <option value="both">Web y tienda física</option>
        <option value="web">Solo tienda web</option>
        <option value="store">Solo tienda física</option>
    </select>
</div>
                    <button type="submit" class="btn btn-primary">
                        Agregar producto
                    </button>
                </form>
            </div>
        </div>

    </div>

@endsection
