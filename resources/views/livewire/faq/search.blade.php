<div class="container px-0">
    <form class="mb-4 d-md-flex">
        <div class="w-100" data-toggle="lists">
            <input wire:model="search" type="search" class="form-control search" placeholder="Search" aria-label="Search"/>
            @if(strlen($search) > 0)
                <div class="dropdown-menu dropdown-menu-card search-results show w-100 mt-3 pb-5">
                    @if($faqsWithCategories->count() || $faqs->count())
                        <div class="list-group list-group-flush list">
                            @foreach($faqsWithCategories as $faqsWithCategory)
                                <div class="list-group-item align-items-center py-3 pl-4">
                                    <a href="{{ action('Web\FaqCategoryController@show', [$faqsWithCategory->category, '#faq_' . $faqsWithCategory->id]) }}" class="text-body">
                                        {{ $faqsWithCategory->title }}
                                    </a>
                                </div>
                            @endforeach

                            @foreach($faqs as $faq)
                                <div class="list-group-item align-items-center py-3 pl-4">
                                    <a href="{{ action('Web\FaqCategoryController@show', [$faq->category, '#faq_' . $faq->id]) }}" class="text-body">
                                        {{ $faq->title }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="list-group list-group-flush list">
                           <i class="text-muted">{{ __('No results') }}</i>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </form>
</div>

@section('script')
    <script type="text/javascript">
        $(window).click(function() {
            $('.search-results').removeClass('show');
        });

        $('.dropdown-menu-container').click(function(event){
            event.stopPropagation();
            $('.search-results').addClass('show');
        });
    </script>
@append
