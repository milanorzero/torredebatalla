@extends('admin.maindesign')

@section('add_product')

    @if(session('product_updated_message'))
         <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
           {{ session('product_updated_message') }}
         </div>
    @endif

    <div class="container-fluid">
        
        <form action="{{ route('admin.postupdateproduct', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- TÍTULO --}}
            <input type="text" 
                   name="product_title" 
                   value="{{ $product->product_title }}" 
                   placeholder="Ingresar nombre del producto">
            <br><br>

            {{-- DESCRIPCIÓN --}}
            <textarea name="product_description" 
                      placeholder="Ingresar descripción del producto">{{ $product->product_description }}</textarea>
            <br><br>

            {{-- CANTIDAD --}}
            <input type="number" 
                   name="product_quantity" 
                   value="{{ $product->product_quantity }}"
                   placeholder="Ingresar cantidad del producto">
            <br><br>

            {{-- PRECIO --}}
            <input type="number" 
                   name="product_price" 
                   value="{{ $product->product_price }}"
                   placeholder="Ingresar precio del producto">
            <br><br>

            {{-- IMAGEN --}}
            <img style="width: 100px;" src="{{ asset('products/' . $product->product_image) }}">
            <br>
            <label>Actualizar imagen</label>
            <input type="file" name="product_image">
            <br><br>

            {{-- CATEGORÍA --}}
            <select name="product_category"> 
                <option value="{{ $product->product_category }}" selected>
                    {{ $product->product_category }}
                </option>

                @foreach($categories as $category)
                    @if($category->category != $product->product_category)
                        <option value="{{ $category->category }}">{{ $category->category }}</option> 
                    @endif
                @endforeach
            </select>
            <br><br>

            <input type="submit" name="submit" value="Actualizar producto">
        </form>

    </div>

@endsection