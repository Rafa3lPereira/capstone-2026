@extends('layouts.authenticated', ['title' => 'Nueva recepción | Almapan'])

@section('page')
    @php
        $showSuppliers = config('navigation.suppliers');
        $selectedOrigin = old('tipo_origen');
        $originLabels = [
            'interno' => ['Entrega interna', 'Mercadería aportada por un usuario interno de la panadería.'],
            'otro_autorizado' => ['Otro origen autorizado', 'Mercadería de otra procedencia que requiere autorización.'],
            'proveedor' => ['Proveedor', 'Mercadería entregada por un proveedor registrado.'],
        ];
        $customTime = filled(old('ocurrido_en')) || filled(old('ocurrido_en_occurrence'))
            || filled(old('motivo_ajuste_ocurrido_en'))
            || $errors->hasAny(['ocurrido_en', 'ocurrido_en_occurrence', 'motivo_ajuste_ocurrido_en']);
        $showOldReason = filled(old('motivo_ajuste_ocurrido_en')) || $errors->has('motivo_ajuste_ocurrido_en');
        $serverNow = \Carbon\CarbonImmutable::now('UTC');
        $santiagoTransitions = (new \DateTimeZone('America/Santiago'))->getTransitions(
            \Carbon\CarbonImmutable::create(1000, 1, 1, 0, 0, 0, 'UTC')->subDay()->getTimestamp(),
            $serverNow->addYear()->getTimestamp(),
        );
    @endphp

    <section class="articles-page inventory-page receipt-create-page" aria-labelledby="receipt-create-title">
        <header class="articles-page-header">
            <div>
                <p class="eyebrow">Inventario</p>
                <h1 id="receipt-create-title">Nueva recepción</h1>
            </div>
            <a class="secondary-button inline-button" href="{{ route('receipts.index') }}">Volver</a>
        </header>

        <div class="receipt-create-guide">
            <ol>
                <li>Crear el borrador.</li>
                <li>Agregar los productos recibidos.</li>
                <li>Revisar y confirmar la recepción.</li>
            </ol>
            <p>El stock se actualiza al confirmar la recepción.</p>
        </div>

        @if ($errors->any())
            <div class="form-alert" role="alert">{{ $errors->first() }}</div>
        @endif

        <section class="articles-panel">
            <form class="article-form" method="POST" action="{{ route('receipts.store') }}" data-receipt-create>
                @csrf

                <fieldset class="receipt-create-origin">
                    <legend>Origen de la mercadería</legend>
                    <div class="receipt-create-options">
                        @foreach ($origins as $origin)
                            @continue(!$showSuppliers && $origin === \App\Enums\ReceiptOriginType::Supplier)
                            <label class="receipt-create-option">
                                <input type="radio" name="tipo_origen" value="{{ $origin->value }}" required
                                    @checked($selectedOrigin === $origin->value)>
                                <span>
                                    <strong>{{ $originLabels[$origin->value][0] }}</strong>
                                    <small>{{ $originLabels[$origin->value][1] }}</small>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>

                @if ($showSuppliers)
                    <label class="field-group" data-receipt-origin-fields="proveedor" @if ($selectedOrigin !== 'proveedor') hidden @endif>
                        <span>Proveedor</span>
                        <select class="form-input" name="proveedor_id" @disabled($selectedOrigin !== 'proveedor')>
                            <option value="">Selecciona un proveedor</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected(old('proveedor_id') == $supplier->id)>
                                    {{ $supplier->nombre }} · {{ $supplier->codigo }}
                                </option>
                            @endforeach
                        </select>
                        @error('proveedor_id')
                            <small class="field-error">{{ $message }}</small>
                        @enderror
                    </label>
                @endif

                <div class="field-group" data-receipt-origin-fields="interno" @if ($selectedOrigin !== 'interno') hidden @endif>
                    <label for="receipt-create-contributor">Usuario que aporta la mercadería</label>
                    <select id="receipt-create-contributor" class="form-input" name="usuario_aportante_id" required
                        aria-describedby="receipt-create-contributor-help{{ $errors->has('usuario_aportante_id') ? ' receipt-create-contributor-error' : '' }}"
                        @error('usuario_aportante_id') aria-invalid="true" @enderror
                        @disabled($selectedOrigin !== 'interno')>
                        <option value="">Selecciona un usuario</option>
                        @foreach ($contributors as $contributor)
                            <option value="{{ $contributor->id }}" @selected(old('usuario_aportante_id') == $contributor->id)>
                                {{ $contributor->nombre }} {{ $contributor->apellido }}
                            </option>
                        @endforeach
                    </select>
                    <small class="form-help" id="receipt-create-contributor-help">Selecciona a la persona de la panadería que entrega los productos.</small>
                    @error('usuario_aportante_id')
                        <small class="field-error" id="receipt-create-contributor-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field-group" data-receipt-origin-fields="otro_autorizado" @if ($selectedOrigin !== 'otro_autorizado') hidden @endif>
                    <label for="receipt-create-origin-detail">Detalle del origen autorizado</label>
                    <input id="receipt-create-origin-detail" class="form-input" type="text" name="origen_detalle"
                        value="{{ old('origen_detalle') }}" required pattern=".*\S.*"
                        placeholder="Ej.: Mercadería entregada por una persona externa, autorizada por administración"
                        aria-describedby="receipt-create-origin-detail-help{{ $errors->has('origen_detalle') ? ' receipt-create-origin-detail-error' : '' }}"
                        @error('origen_detalle') aria-invalid="true" @enderror
                        @disabled($selectedOrigin !== 'otro_autorizado')>
                    <small class="form-help" id="receipt-create-origin-detail-help">Indica quién entrega la mercadería y por qué se autorizó su recepción.</small>
                    @error('origen_detalle')
                        <small class="field-error" id="receipt-create-origin-detail-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="receipt-create-time">
                    <label class="receipt-create-time-toggle">
                        <input type="checkbox" data-receipt-custom-time aria-controls="receipt-create-time-fields"
                            aria-describedby="receipt-create-time-help" @checked($customTime)>
                        Registrar con otra fecha y hora
                    </label>
                    <p class="form-help" id="receipt-create-time-help">Por defecto se usa la fecha y hora actual de Santiago.</p>

                    <fieldset id="receipt-create-time-fields" class="receipt-create-time-fields" aria-label="Fecha y hora de recepción"
                        @if (!$customTime) hidden disabled @endif>
                        <div class="field-group">
                            <label for="receipt-create-date">Fecha y hora de Santiago</label>
                            <input id="receipt-create-date" class="form-input" type="datetime-local" name="ocurrido_en"
                                value="{{ old('ocurrido_en') }}"
                                @error('ocurrido_en') aria-invalid="true" aria-describedby="receipt-create-date-error" @enderror>
                            @error('ocurrido_en')
                                <small class="field-error" id="receipt-create-date-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="field-group" data-receipt-occurrence
                            @if (!$errors->has('ocurrido_en_occurrence') && !filled(old('ocurrido_en_occurrence'))) hidden @endif>
                            <x-ui.commercial-time-occurrence field="ocurrido_en" label="Hora de la recepción" />
                            @error('ocurrido_en_occurrence')
                                <small class="field-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="field-group" data-receipt-reason @if (!$showOldReason) hidden @endif>
                            <label for="receipt-create-reason">Motivo del registro retroactivo</label>
                            <input id="receipt-create-reason" class="form-input" type="text" name="motivo_ajuste_ocurrido_en"
                                value="{{ old('motivo_ajuste_ocurrido_en') }}" @disabled(!$showOldReason)
                                @error('motivo_ajuste_ocurrido_en') aria-invalid="true" aria-describedby="receipt-create-reason-error" @enderror>
                            @error('motivo_ajuste_ocurrido_en')
                                <small class="field-error" id="receipt-create-reason-error">{{ $message }}</small>
                            @enderror
                        </div>
                    </fieldset>
                </div>

                <div class="field-group">
                    <label for="receipt-create-observation">Observación (opcional)</label>
                    <textarea id="receipt-create-observation" class="form-input" name="observacion" rows="2"
                        placeholder="Ej.: Mercadería recibida en buen estado, sin diferencias en las cantidades."
                        aria-describedby="receipt-create-observation-help{{ $errors->has('observacion') ? ' receipt-create-observation-error' : '' }}"
                        @error('observacion') aria-invalid="true" @enderror>{{ old('observacion') }}</textarea>
                    <small class="form-help" id="receipt-create-observation-help">Agrega información adicional que ayude a revisar la recepción.</small>
                    @error('observacion')
                        <small class="field-error" id="receipt-create-observation-error">{{ $message }}</small>
                    @enderror
                </div>

                <button class="primary-button receipt-create-submit" type="submit">Crear borrador</button>
            </form>
        </section>
    </section>

    @push('scripts')
        <script>
            (() => {
                const form = document.querySelector('[data-receipt-create]');
                const groups = form.querySelectorAll('[data-receipt-origin-fields]');
                const updateOrigin = () => {
                    const origin = form.elements.tipo_origen.value;
                    groups.forEach((group) => {
                        const active = group.dataset.receiptOriginFields === origin;
                        group.hidden = !active;
                        group.querySelector('[name]').disabled = !active;
                    });
                };

                const customTime = form.querySelector('[data-receipt-custom-time]');
                const timeFields = document.getElementById('receipt-create-time-fields');
                const date = form.elements.ocurrido_en;
                const occurrence = form.elements.ocurrido_en_occurrence;
                const occurrenceField = form.querySelector('[data-receipt-occurrence]');
                const occurrenceDetails = occurrenceField.querySelector('details');
                const reason = form.elements.motivo_ajuste_ocurrido_en;
                const reasonField = form.querySelector('[data-receipt-reason]');
                const transitions = {{ \Illuminate\Support\Js::from(array_map(
                    static fn ($transition) => [$transition['ts'], $transition['offset']],
                    $santiagoTransitions,
                )) }};
                const serverNow = {{ $serverNow->getTimestampMs() }} / 1000;
                const loadedAt = performance.now();
                let restoreOccurrence = @json($errors->has('ocurrido_en_occurrence') || filled(old('ocurrido_en_occurrence')));
                let restoreReason = @json($showOldReason);
                let dateTimer;

                const updateTime = () => {
                    clearTimeout(dateTimer);
                    timeFields.hidden = timeFields.disabled = !customTime.checked;

                    // Interpret the wall time against the server's Santiago offsets, never the device's time zone.
                    const wallTime = Date.parse(date.value + 'Z') / 1000;
                    const instants = transitions.flatMap(([start, offset], index) => {
                        const instant = wallTime - offset;
                        const end = transitions[index + 1]?.[0] ?? Infinity;
                        return instant >= start && instant < end ? [instant] : [];
                    });
                    const ambiguous = instants.length === 2;
                    occurrenceField.hidden = occurrence.disabled = !ambiguous && !restoreOccurrence;
                    occurrence.required = ambiguous;
                    if (ambiguous) occurrenceDetails.open = true;

                    const selectedInstant = ambiguous
                        ? instants[['primera', 'segunda'].indexOf(occurrence.value)]
                        : instants[0];
                    const serverTime = serverNow + (performance.now() - loadedAt) / 1000;
                    const retroactive = selectedInstant < serverTime;
                    reasonField.hidden = reason.disabled = !retroactive && !restoreReason;
                    reason.required = retroactive;

                    if (customTime.checked && selectedInstant >= serverTime) {
                        const delay = Math.min((selectedInstant - serverTime) * 1000 + 20, 2_147_483_647);
                        dateTimer = setTimeout(updateTime, delay);
                    }
                };

                form.addEventListener('change', (event) => {
                    if (event.target.name === 'tipo_origen') updateOrigin();
                    if (event.target === occurrence || event.target === customTime) updateTime();
                });
                occurrence.addEventListener('invalid', () => {
                    occurrenceDetails.open = true;
                });
                date.addEventListener('input', () => {
                    occurrence.value = '';
                    restoreOccurrence = restoreReason = false;
                    updateTime();
                });
                window.addEventListener('pageshow', () => {
                    updateOrigin();
                    updateTime();
                });
                updateOrigin();
                updateTime();
            })();
        </script>
    @endpush
@endsection
