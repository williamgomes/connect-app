@if($faqCategory->parent)
    @include('web.faq.categories.breadcrumbs', ['faqCategory' => $faqCategory->parent])
@endif

<li class="breadcrumb-item">
    <a href="{{ action('Web\FaqCategoryController@show', $faqCategory) }}" class="text-gray-700">{{ $faqCategory->name }}</a>
</li>
