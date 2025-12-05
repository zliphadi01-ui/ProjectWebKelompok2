<div class="card stat-card h-100 border-0">
    <div class="card-body position-relative p-4">
        <div class="d-flex flex-column position-relative z-1">
            <div class="text-uppercase fw-bold text-{{ $color ?? 'primary' }} small mb-2 tracking-wide" style="letter-spacing: 0.05em;">
                {{ $title }}
            </div>
            <div class="h2 fw-bold text-dark mb-0" id="{{ $id ?? '' }}">
                {{ $value }}
            </div>
            <div class="small text-muted mt-2">
                @if(isset($trend))
                    <i class="bi-{{ $trend == 'up' ? 'arrow-up-short' : 'arrow-down-short' }} text-{{ $trendColor ?? 'success' }}"></i>
                    {{ $trendText ?? '' }}
                @else
                    {{ $subtitle ?? '' }}
                @endif
            </div>
        </div>
        <div class="icon-bg text-{{ $color ?? 'primary' }} opacity-10 position-absolute end-0 bottom-0 p-3" style="font-size: 4rem; transform: rotate(-15deg); opacity: 0.1;">
            <i class="bi-{{ $icon }}"></i>
        </div>
    </div>
</div>
