<div class="flex justify-between items-center p-2">
    <div class="@if($top) none @else flex justify-around @endif fixed inset-x-0 bottom-0 md:inline-block md:static md:inset-x-auto md:bottom-auto bg-main-vdark border-t border-main-dark md:border-none">
        <a x-ref="firstPage" class="text-3xl md:text-lg px-4 py-2 focus:outline-none hover:text-orange-500 @if($paginator->onFirstPage()) opacity-25 @endif" href="{{ $paginator->onFirstPage() ? 'javascript:void(0)' : $paginator->url(1) }}"><i class="fas fa-angle-double-left"></i></a>

        <a x-ref="previousPage" class="text-3xl md:text-lg px-4 py-2 focus:outline-none hover:text-orange-500 @if($paginator->onFirstPage()) opacity-25 @endif" href="{{ $paginator->onFirstPage() ? 'javascript:void(0)' : $paginator->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a>

        <span class="text-3xl md:text-xl h-10 px-4 py-2 cursor-default font-black">{{ $paginator->currentPage() }}</span>

        <a x-ref="nextPage" class="text-3xl md:text-lg px-4 py-2 focus:outline-none hover:text-orange-500 @if(! $paginator->hasMorePages()) opacity-25 @endif" href="{{ ! $paginator->hasMorePages() ? 'javascript:void(0)' : $paginator->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>

        <a x-ref="lastPage" class="text-3xl md:text-lg px-4 py-2 focus:outline-none hover:text-orange-500 @if(! $paginator->hasMorePages()) opacity-25 @endif" href="{{ ! $paginator->hasMorePages() ? 'javascript:void(0)' : $paginator->url($paginator->lastPage()) }}"><i class="fas fa-angle-double-right"></i></a>

        <button x-on:click="window.scrollTo(0,0);" class="inline-block md:hidden py-2 pr-4 focus:outline-none">
            <span class="fa-stack">
                <i class="fas fa-circle fa-stack-2x text-gray-900"></i>
                <i class="fas fa-arrow-up fa-stack-1x"></i>
            </span>
        </button>
    </div>

    <div class="w-full flex justify-between md:w-auto md:inline-block">
        <div class="block md:inline md:border-r-2 md:border-white md:pr-3 md:mr-2">
            <strong>{{ $paginator->firstItem() }}</strong>
            <span>to</span>
            <strong>{{ $paginator->lastItem() }}</strong>
            <span>of</span>
            <strong>{{ $paginator->total() }}</strong>
        </div>

        <div class="block md:inline">
            <form x-ref="perPageForm" method="GET" action="/saves" class="inline">
                @csrf
                <select class="inline-block text-black" x-on:change="$wire.updatePerPage($event.target.value)">
                    <option @if($perPage === '15') selected @endif value="15">15</option>
                    <option @if($perPage === '25') selected @endif value="25">25</option>
                    <option @if($perPage === '50') selected @endif value="50">50</option>
                </select>
            </form>
            per page
        </div>
    </div>
</div>
