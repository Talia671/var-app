@props(['status'])

@php
    $class = match($status){
        'approved' => 'badge-approved',
        'rejected' => 'badge-rejected',
        default => 'badge-pending'
    };

    $dot = match($status){
        'approved' => 'dot-approved',
        'rejected' => 'dot-rejected',
        default => 'dot-pending'
    };
@endphp

<span class="badge-status {{ $class }}">
    <span class="badge-dot {{ $dot }}"></span>
    {{ $status }}
</span>