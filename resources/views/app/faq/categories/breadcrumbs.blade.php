@if($faqCategory->parent)
    @include('app.faq.categories.breadcrumbs', ['faqCategory' => $faqCategory->parent])
@endif
/
<a href="{{ action('App\FaqCategoryController@show', $faqCategory) }}">{{ $faqCategory->name }}</a>

