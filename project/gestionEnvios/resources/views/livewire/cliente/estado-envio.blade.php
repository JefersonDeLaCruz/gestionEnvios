<div class="w-full">

    {{-- Loading: solo cuando se llama buscarDesdeEvento --}}
    <div wire:loading wire:target="buscarDesdeEvento" class="mt-3">
        <div class="alert alert-info">Actualizando estado...</div>
    </div>

    {{-- Error --}}
    <div class="mt-4">
        @if (! empty($errorMessage ?? null))
            <div class="alert alert-error mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728" />
                </svg>
                <span>{{ $errorMessage }}</span>
            </div>
        @endif
    </div>

    {{-- Si ya hay un envío, activamos el poll para refrescar periódicamente --}}
    @if (! empty($envio ?? null))
        <div wire:poll.5000ms="refreshStatus" class="mt-4">

            {{-- ALERT --}}
            @if (! empty($estado ?? null))
                @php $slug = strtolower($estado->slug ?? $estado->nombre ?? ''); @endphp

                @if ($slug === 'pendiente')
                    <div class="alert alert-warning mt-4">Estado: {{ $estado->nombre }}</div>
                @elseif ($slug === 'enviado')
                    <div class="alert alert-info mt-4">Estado: {{ $estado->nombre }}</div>
                @elseif ($slug === 'entregado')
                    <div class="alert alert-success mt-4">Estado: {{ $estado->nombre }}</div>
                @endif
            @endif

            {{-- Datos del paquete --}}
            <div class="mt-5 p-4 border rounded">
                <p><strong>Código:</strong> {{ $paquete->codigo ?? 'N/A' }}</p>
                <p><strong>Peso:</strong> {{ $paquete->peso ?? 'N/A' }}</p>
                <p><strong>Fecha estimada:</strong>
                    @if(! empty($envio->fecha_estimada ?? null) && method_exists($envio->fecha_estimada, 'format'))
                        {{ $envio->fecha_estimada->format('Y-m-d') }}
                    @else
                        {{ $envio->fecha_estimada ?? 'N/A' }}
                    @endif
                </p>
                <p><strong>Costo:</strong> {{ $envio->costo ?? 'N/A' }}</p>
            </div>

            {{-- STEPS --}}
            @php
                $steps = ['Pendiente','Enviado','Entregado'];
                $active = $this->activeStep ?? -1;
            @endphp

            <ul class="steps steps-vertical mt-6">
                @foreach ($steps as $i => $s)
                    <li class="step {{ ($i <= $active) ? 'step-primary' : '' }}">{{ $s }}</li>
                @endforeach
            </ul>

        </div>
    @else
        <p class="mt-4 opacity-70">Aquí aparecerá el estado del paquete una vez ingreses un código.</p>
    @endif

</div>
