@php
    $currentPage = $current;
    $totalPages = ceil($total / $length);
    $currentUrl = url()->current();
@endphp

<ul class="pagination pull-right">
    {{-- Previous Page --}}
    <li class="{{ $currentPage <= 1 ? 'disabled' : '' }}">
        <a href="@if($currentPage <= 1) javascript:; @else {{ $currentUrl }}?page={{ $currentPage - 1 }} @endif"><span class="fa fa-angle-left"></span></a>
    </li>

    {{-- First Page and Ellipsis --}}
    @if ($currentPage - $size > 1)
        <li><a href="{{ $currentUrl }}?page=1">1</a></li>
        <li><span>...</span></li>
    @endif

    {{-- Pages --}}
    @for ($i = max(1, $currentPage - $size); $i <= min($totalPages, $currentPage + $size); $i++)
        <li class="{{ $currentPage == $i ? 'active' : '' }}">
            <a href="{{ $currentUrl }}?page={{ $i }}">{{ $i }}</a>
        </li>
    @endfor

    {{-- Last Page and Ellipsis --}}
    @if ($currentPage + $size < $totalPages)
        <li><span>...</span></li>
        <li><a href="{{ $currentUrl }}?page={{ $totalPages }}">{{ $totalPages }}</a></li>
    @endif

    {{-- Next Page --}}
    <li class="{{ $currentPage >= $totalPages ? 'disabled' : '' }}">
        <a href="@if($currentPage >= $totalPages) javascript:; @else {{ $currentUrl }}?page={{ $currentPage + 1 }} @endif"><span class="fa fa-angle-right"></span></a>
    </li>
</ul>
