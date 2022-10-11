@extends('web.layouts.app')

@section('title', 'Blog')

@section('content')
    <header class="bg-dark pt-9 pb-11 d-none d-md-block">
        <div class="container-md">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="font-weight-bold text-white mb-2">
                        {{ __('Our Blog') }}
                    </h1>
                    <p class="font-size-lg text-white-75 mb-0">
                        {{ __('Stay tuned with the latest news from the Connect Team')}}
                    </p>
                </div>
            </div>
        </div>
    </header>
    <section class="mt-n6">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @foreach($blogPosts as $blogPost)
                        <div class="card card-row shadow-light-lg mb-6">
                            <div class="row no-gutters">
                                <div class="col-12 order-md-1">
                                    <div class="card-body pt-8 pb-5">
                                        <h3>
                                            {{ $blogPost->title }}
                                        </h3>
                                        <small class="text-muted">{{ $blogPost->category }}</small>
                                        <p class="mb-0 mt-6">
                                            {!!  strip_tags(\Illuminate\Support\Str::limit($blogPost->content, 250, $end='...')) !!}
                                        </p>
                                    </div>

                                    <div class="card-meta row">
                                        <hr class="card-meta-divider mx-4">

                                        <h6 class="text-uppercase text-muted mb-0 col">
                                            {{ $blogPost->user->name }}
                                            <time class="ml-4" datetime="{{ $blogPost->created_at }}">{{ \App\Helpers\TimeHelper::blogFormattedDate($blogPost->created_at) }}</time>
                                        </h6>
                                        <div class="col-auto mb-0">
                                            <a href="{{ action('Web\BlogController@show', $blogPost) }}" class="btn btn-xs btn-primary">{{ __('Read more') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container mb-10">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <hr class="border-gray-300 mb-8">
                    <h2>{{ __('Do you require any help?') }}</h2>
                </div>
                @include('web.help-center.all-categories')
            </div>
        </div>
    </section>
@endsection


