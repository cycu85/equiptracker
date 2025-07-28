@props(['field', 'title'])

@php
$sortField = request('sort');
$sortDirection = request('direction', 'asc');
$isActive = $sortField === $field;
$nextDirection = $isActive && $sortDirection === 'asc' ? 'desc' : 'asc';
$query = array_merge(request()->query(), ['sort' => $field, 'direction' => $nextDirection]);
@endphp

<th>
    <a href="{{ request()->url() }}?{{ http_build_query($query) }}" 
       class="text-decoration-none text-dark d-flex align-items-center justify-content-between">
        <span>{{ $title }}</span>
        <span class="ms-1">
            @if($isActive)
                @if($sortDirection === 'asc')
                    <i class="fas fa-sort-up text-primary"></i>
                @else
                    <i class="fas fa-sort-down text-primary"></i>
                @endif
            @else
                <i class="fas fa-sort text-muted"></i>
            @endif
        </span>
    </a>
</th>