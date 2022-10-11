<section class="mt-n2">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card card-row shadow-light-lg mb-6">
                    <div class="card-body pt-7 pb-5">
                        @foreach($faqs as $faq)
                            @cannot('view', $faq)
                                @php()
                                  continue;
                                @endphp
                            @endcan
                            <div class="card">
                                <div id="headingFaq_{{ $faq->id }}">
                                    <a class="btn w-100" data-toggle="collapse" data-target="#faq_{{ $faq->id }}" aria-expanded="true" aria-controls="faq_{{ $faq->id }}">
                                        <h2 class="text-left float-left">
                                            <b>{{ $faq->title }}</b>
                                        </h2>
                                        <span class="float-right mt-2">
                                            <i class="fe fe-plus fe-lg faq-icon"></i>
                                        </span>
                                    </a>
                                </div>

                                <div id="faq_{{ $faq->id }}" class="collapse" aria-labelledby="headingFaq_{{ $faq->id }}">
                                    <div class="card-body pt-6 pb-4">
                                        <div class="align-items-center row pl-2">
                                            <div class="col-auto pl-0 pr-2">
                                                <div class="avatar avatar-xl p-md-2 p-0 mb-1 account-img">
                                                    <img src="{{ Storage::disk('s3')->temporaryUrl('images/profile/' . $faq->user->profile_picture, now()->addMinutes(5)) }}" class="avatar-img rounded-circle border border-4 border-body">
                                                </div>
                                            </div>
                                            <div class="col pl-0">
                                                <span>{{ $faq->user->name }}</span>
                                                <br>
                                                <small>
                                                    <span class="text-muted" title="{{ $faq->created_at->format('d. M Y, h:i T') }}">{{ $faq->created_at->diffForHumans() }}</span>
                                                </small>
                                            </div>
                                        </div>

                                        {!! $faq->content !!}
                                    </div>
                                </div>
                                <hr/>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('script')
    <script type="text/javascript">
        // Toggle plus minus icon on show hide of collapse element
        $('.collapse').on('show.bs.collapse', function () {
            $(this).closest('.card').find('.faq-icon').removeClass('fe-plus').addClass('fe-minus');
        }).on('hide.bs.collapse', function () {
            $(this).closest('.card').find('.faq-icon').removeClass('fe-minus').addClass('fe-plus');
        });

        $(window).on('hashchange', function() {
            handleHashChange();
        });

        handleHashChange();

        function handleHashChange() {
            let id = window.location.hash;

            if (id) {
                let title = $('[data-target="' + id + '"]');

                $('html, body').animate({scrollTop: title.offset().top -200 }, 'slow');

                setTimeout(function () {
                    title.click();
                }, 500);
            }
        }
    </script>
@append
