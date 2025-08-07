@php
    $type = strtolower($type);
@endphp

<span class="inline-block text-xs font-semibold px-2 py-0.5 rounded
    @switch($type)
        @case('produit périmé') bg-red-100 text-red-700 @break
        @case('rupture de stock') bg-red-200 text-red-800 @break
        @case('alerte rouge') bg-red-100 text-red-700 @break
        @case('alerte orange') bg-orange-100 text-orange-700 @break
        @case('alerte verte') bg-green-100 text-green-700 @break
        @default bg-gray-100 text-gray-700
    @endswitch">
    {{ ucfirst($type) }}
</span>
