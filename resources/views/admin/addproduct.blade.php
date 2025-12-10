@extends('admin.maindesign')

@section('add_product')

    @if(session('product_message'))
         <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
           {{ session('product_message') }}
         </div>
    @endif

    <div class="container-fluid">
        
        <form action="{{ route('admin.postaddproduct') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <input type="text" name="product_title" placeholder="Ingresar nombre producto">
            <br><br>

            <textarea name="product_description" placeholder="Ingresar descripcion del producto"></textarea>
            <br><br>

            <input type="number" name="product_quantity" placeholder="Ingresar cantidad del producto">
            <br><br>

            <input type="number" name="product_price" placeholder="Ingresar precio del producto">
            <br><br>
            <input type="file" name="product_image">
            <br><br>

            <select name="product_category"> 
                @foreach($categories as $category)
                    <option value="{{ $category->category }}">{{ $category->category }}</option> 
                @endforeach
            </select>
            <br><br>

            <input type="submit" name="submit" value="Add product">
        </form>

    </div>

@endsection
