<div class="flex justify-between items-center p-2" x-data>
    <div class="flex justify-around fixed inset-x-0 bottom-0 bg-gray-900 md:inline-block md:static md:inset-x-auto md:bottom-auto z-10">
        <a @if($paginator->onFirstPage()) disabled @endif class="text-3xl md:text-lg px-4 outline-none hover:text-orange-500 @if($paginator->onFirstPage()) opacity-25 @endif" href="{{ $paginator->url(1) }}"><i class="fas fa-angle-double-left"></i></a>

        <a @if($paginator->onFirstPage()) disabled @endif class="text-3xl md:text-lg px-4 outline-none hover:text-orange-500 @if($paginator->onFirstPage()) opacity-25 @endif" href="{{ $paginator->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a>

        <span class="text-3xl md:text-xl h-10 px-4 cursor-default font-black">{{ $paginator->currentPage() }}</span>

        <a @if(! $paginator->hasMorePages()) disabled @endif class="text-3xl md:text-lg px-4 outline-none hover:text-orange-500 @if(! $paginator->hasMorePages()) opacity-25 @endif" href="{{ $paginator->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>

        <a @if(! $paginator->hasMorePages()) disabled @endif class="text-3xl md:text-lg px-4 outline-none hover:text-orange-500 @if(! $paginator->hasMorePages()) opacity-25 @endif" href="{{ $paginator->url($paginator->lastPage()) }}"><i class="fas fa-angle-double-right"></i></a>
    </div>

    <div class="w-full flex justify-between md:w-auto md:inline-block">
        <div class="block md:inline md:border-r-2 md:border-white md:pr-3 md:mr-2">
            <strong>{{ $paginator->firstItem() }}</strong> to
            <strong>{{ $paginator->lastItem() }}</strong> of
            <strong>{{ $paginator->total() }}</strong>
        </div>

        <div class="block md:inline">
            <form x-ref="perPageForm" method="GET" action="/home" class="inline">
                @csrf
                <select name="perPage" class="inline-block text-black" @change="$refs.perPageForm.submit()">
                    <option value="15" @if($perPage === '15') selected @endif>15</option>
                    <option value="25" @if($perPage === '25') selected @endif>25</option>
                    <option value="50" @if($perPage === '50') selected @endif>50</option>
                </select>
            </form>
            per page
        </div>
    </div>
</div>
