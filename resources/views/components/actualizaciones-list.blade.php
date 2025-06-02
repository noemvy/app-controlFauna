@if($actualizaciones->isEmpty())
    <p>No hay actualizaciones registradas para este reporte.</p>
    @else
    <div style="max-width: 600px; margin: 0 auto;">
        @foreach($actualizaciones as $actualizacion)
            <div style="border: 1px solid #ccc; border-radius: 5px; padding: 15px; margin-bottom: 15px; background-color: #f9f9f9;">
                <p style="
                    font-size: 16px;
                    color: #333;
                    margin-bottom: 10px;
                    max-height: 80px;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    display: -webkit-box;
                    -webkit-line-clamp: 3; /* Número de líneas a mostrar */
                    -webkit-box-orient: vertical;
                    word-wrap: break-word;
                    white-space: normal;">
                    {{ $actualizacion->actualizacion }}
                </p>
                <small style="display: block; font-size: 14px; color: #666;">
                    Por: <strong>{{ $actualizacion->user->name }}</strong>
                    el <strong>{{ $actualizacion->created_at->format('d-m-Y H:i:s') }}</strong>
                </small>
            </div>
        @endforeach
    </div>
@endif
