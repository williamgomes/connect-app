@if($faqCategories->count())
    <div class="table-responsive">
        <table class="table card-table table-sm table-hover">
            <thead>
            <tr>
                <th style="width: 50px;"></th>
                <th>
                    {{ __('Name') }}
                </th>
                <th>
                    {{ __('Active') }}
                </th>
                <th class="text-right">
                    {{ __('Actions') }}
                </th>
            </tr>
            </thead>
            <tbody class="sortable sortable-faq-categories">
            @foreach ($faqCategories as $category)
                <tr data-id="{{ $category->id }}">
                    <td>
                        @can('sort', \App\Models\FaqCategory::class)
                            <span class="fe fe-maximize-2 mr-2"></span>
                        @endcan
                    </td>
                    <td>
                        <a href="{{ action('App\FaqCategoryController@show', $category) }}">{{ $category->name }}</a>
                    </td>
                    <td>
                        @if ($category->active)
                            <span class="text-success">●</span>
                            {{ __('Yes') }}
                        @else
                            <span class="text-danger">●</span>
                            {{ __('No') }}
                        @endif
                    </td>
                    <td class="text-right">
                        <div class="dropdown">
                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fe fe-more-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ action('App\FaqCategoryController@show', $category) }}" class="dropdown-item">{{ __('View') }}</a>
                                <a href="{{ action('App\FaqCategoryController@edit', $category) }}" class="dropdown-item">{{ __('Edit') }}</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="card-body text-center">
        <i class="text-muted">{{ __('No FAQ Categories') }}</i>
    </div>
@endif

@can('sort', \App\Models\FaqCategory::class)
    @include('app.faq.sortable-script', ['type' => 'faq-categories', 'url' => action('Ajax\FaqCategoryController@sort')])
@endcan