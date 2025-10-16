@if ($paginator->hasPages())
<div class="flex justify-center mt-6 space-x-2">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span class="px-3 py-1 bg-gray-200 rounded text-gray-500">Prev</span>
    @else
        <button wire:click="gotoPage({{ $paginator->currentPage() - 1 }})" 
                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Prev</button>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="px-3 py-1 bg-blue-600 text-white rounded">{{ $page }}</span>
                @else
                    <button wire:click="gotoPage({{ $page }})" 
                            class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">{{ $page }}</button>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <button wire:click="gotoPage({{ $paginator->currentPage() + 1 }})" 
                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Next</button>
    @else
        <span class="px-3 py-1 bg-gray-200 rounded text-gray-500">Next</span>
    @endif
</div>
@endif
