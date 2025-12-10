@extends('admin.maindesign')

@section('view_category')

@if(session('deletecategory_message'))
<div style="margin-bottom: 10px; color: black; background-color: orangered;">
    {{session('deletecategory_message')}}
</div>
@endif

@if(session('deleteproduct_message'))
<div style="margin-bottom: 10px; color: black; background-color: orangered;">
    {{session('deleteproduct_message')}}
</div>
@endif
<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
  <thead>
    <tr style="background-color: #f2f2f2;">
      <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Producto</th>
      <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Descripcion del producto</th>
      <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Cantidad</th>
      <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Precio</th>
      <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Imagen</th>
      <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Categoria</th>
      <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Accion</th>
    </tr>
  </thead>
  <tbody>
    @foreach($products as $product)
    <tr style="border-bottom: 1px solid #ddd;">
      <td style="padding: 12px;">{{$product->product_title}}</td>
      <td style="padding: 12px;">{{Str::limit($product->product_description,150)}}</td>
      <td style="padding: 12px;">{{$product->product_quantity}}</td>
      <td style="padding: 12px;">{{$product->product_price}}</td>
      <td style="padding: 12px;">
        <img style="width: 150px;"src="{{asset('products/'.$product->product_image)}}">
      </td>
      <td style="padding: 12px;">{{$product->product_category}}</td>
      <td style="padding: 12px;">
        <a href="{{route('admin.updateproduct',$product->id)}}" style="color:green">Actualizar</a>
         <a href="{{route('admin.deleteproduct',$product->id)}}" onclick="return confirm('Confirma borrar categoria')" >Borrar</a>
      </td>
    </tr>
    @endforeach

    {{$products->links()}}
  </tbody>
</table>


@endsection