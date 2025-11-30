@props(['title', 'icon', 'color', 'route', 'description', 'soon' => false])

<div class="col-md-3">
    <div class="card border-0 shadow-sm h-100">
        <div class="card-body text-center">
            <div class="mb-3 text-{{ $color }}">
                <i class="bi {{ $icon }}" style="font-size: 2rem;"></i>
            </div>
            <h5 class="card-title">{{ $title }}</h5>
            <p class="card-text small text-muted">{{ $description }}</p>
            @if($soon)
                <button class="btn btn-outline-secondary btn-sm" disabled>Segera Tersedia</button>
            @else
                <a href="{{ $route }}" class="btn btn-{{ $color }} btn-sm">Kelola</a>
            @endif
        </div>
    </div>
</div>
