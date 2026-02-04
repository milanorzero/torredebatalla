@extends('admin.maindesign')

@section('page_title', 'Eventos - Torneos')

@section('content')
<div class="container-fluid">

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Torneos (cupos)</h3>
        <a href="{{ route('admin.events.tournaments.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Publicar torneo
        </a>
    </div>

    <div class="card w-100">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Precio</th>
                            <th>Canal</th>
                            <th>Fecha</th>
                            <th style="width: 160px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tournaments as $t)
                            <tr>
                                <td>{{ $t->product_title }}</td>
                                <td>{{ is_null($t->product_quantity) ? '-' : $t->product_quantity }}</td>
                                <td>${{ number_format((int) $t->final_price, 0, ',', '.') }}</td>
                                <td>{{ $t->sale_channel ?? '-' }}</td>
                                <td>{{ optional($t->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('admin.events.tournaments.edit', $t) }}" class="btn btn-sm btn-info">Editar</a>

                                    @if(!is_null($t->product_quantity) && (int) $t->product_quantity > 0)
                                        <form action="{{ route('admin.events.tournaments.unpublish', $t) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Despublicar este torneo? Dejará los cupos en 0.');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning">Despublicar</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.events.tournaments.destroy', $t) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Eliminar este torneo? Esta acción no se puede deshacer.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No hay torneos publicados aún.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $tournaments->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
