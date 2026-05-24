@props([
    'size' => 'md',          
    'variant' => 'primary',
    'startIcon' => null,
    'endIcon' => null,
    'className' => '',
    'disabled' => false,
])

@php
    // Base classes
    $base = 'inline-flex min-h-11 items-center justify-center gap-2 rounded-xl font-semibold shadow-sm transition focus:outline-none focus:ring-4 disabled:cursor-not-allowed disabled:opacity-60';

    // Size map
    $sizeMap = [
        'sm' => 'px-4 py-2.5 text-sm',
        'md' => 'px-5 py-3 text-sm',
    ];
    $sizeClass = $sizeMap[$size] ?? $sizeMap['md'];

    // Variant map
    $variantMap = [
        'primary' => 'bg-brand-500 text-white hover:bg-brand-600 focus:ring-brand-500/20',
        'outline' => 'bg-white text-slate-700 ring-1 ring-inset ring-slate-300 hover:bg-slate-50 focus:ring-slate-500/10',
    ];
    $variantClass = $variantMap[$variant] ?? $variantMap['primary'];

    // disabled classes
    $disabledClass = $disabled ? 'cursor-not-allowed opacity-50' : '';

    // final classes (merge user className too)
    $classes = trim("{$base} {$sizeClass} {$variantClass} {$className} {$disabledClass}");
@endphp

<button
    {{ $attributes->merge(['class' => $classes, 'type' => $attributes->get('type', 'button')]) }}
    @if($disabled) disabled @endif
>
    {{-- start icon: priority — named slot 'startIcon' first, then startIcon prop if it's a HtmlString --}}
    @if (isset($__env) && $slot->isEmpty() === false) @endif

    @hasSection('startIcon')
        <span class="flex items-center">
            @yield('startIcon')
        </span>
    @elseif($startIcon)
        <span class="flex items-center">{!! $startIcon !!}</span>
    @endif

    {{-- main slot --}}
    {{ $slot }}

    {{-- end icon: named slot 'endIcon' first, then endIcon prop --}}
    @hasSection('endIcon')
        <span class="flex items-center">
            @yield('endIcon')
        </span>
    @elseif($endIcon)
        <span class="flex items-center">{!! $endIcon !!}</span>
    @endif
</button>
