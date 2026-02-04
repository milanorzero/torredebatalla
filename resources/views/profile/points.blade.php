@extends('maindesign')

@section('title', 'Mis puntos')

@section('shop')
<div class="container" style="max-width: 900px;">
    <div class="card shadow-sm w-100">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-3" style="gap: 12px; flex-wrap: wrap;">
                <h2 class="mb-0">Mis puntos</h2>
                <div class="text-muted">
                    Saldo actual: <strong>{{ $user->points_balance }}</strong> pts
                </div>
            </div>

            @if($transactions->count() === 0)
                <div class="alert alert-info mb-0">
                    Todav\u00eda no tienes movimientos de puntos.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Puntos</th>
                                <th>Canal</th>
                                <th>Motivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $tx)
                                <tr>
                                    <td>{{ $tx->created_at?->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @if($tx->type === 'earned')
                                            <span class="badge bg-success">Ganados</span>
                                        @else
                                            <span class="badge bg-danger">Gastados</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($tx->type === 'earned')
                                            <span class="text-success">+{{ $tx->points }}</span>
                                        @else
                                            <span class="text-danger">-{{ $tx->points }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $tx->channel }}</td>
                                    <td>
                                        {{ $tx->reason }}
                                        @if(!is_null($tx->reference_id))
                                            <span class="text-muted">(#{{ $tx->reference_id }})</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $transactions->links() }}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
