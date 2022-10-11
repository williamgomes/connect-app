<div class="col-12 col-md-6 col-lg-4">
    <div class="card card-border border-primary shadow-lg mb-6 mb-md-8 lift lift-lg">
        <div class="card-body text-center">
            <div class="icon-circle bg-primary text-white mb-5">
                <i class="fe fe-lock"></i>
            </div>
            <h4 class="font-weight-bold">
                {{ __('Get a new password') }}
            </h4>

            <p class="text-gray-700 mb-5">
                {{ __("Can't get into OneLogin? Use this category.")}}
            </p>

            <a href="{{ action('Web\SelfServiceController@createPassword') }}" class="btn btn-primary btn-xs mb-1">
                {{ __('Select') }}
            </a>
        </div>
    </div>
</div>
<div class="col-12 col-md-6 col-lg-4">
    <div class="card card-border border-success shadow-lg mb-6 mb-md-8 lift lift-lg">
        <div class="card-body text-center">
            <div class="icon-circle bg-success text-white mb-5">
                <i class="fe fe-smartphone"></i>
            </div>

            <h4 class="font-weight-bold">
                {{ __('Setup DUO Mobile') }}
            </h4>

            <p class="text-gray-700 mb-5">
                {{ __('Do you have a new phone to setup with DUO Mobile?')}}
            </p>

            <a href="{{ action('Web\SelfServiceController@createPhone') }}" class="btn btn-primary btn-xs mb-1">
                {{ __('Select') }}
            </a>
        </div>
    </div>
</div>
<div class="col-12 col-md-6 col-lg-4">
    <div class="card card-border border-warning shadow-lg mb-6 mb-md-8 lift lift-lg">
        <div class="card-body text-center">
            <div class="icon-circle bg-warning text-white mb-5">
                <i class="fe fe-phone-off"></i>
            </div>

            <h4 class="font-weight-bold">
                {{ __('Temporary login code') }}
            </h4>

            <p class="text-gray-700 mb-5">
                {{ __('Is your phone broken and you need a login code?') }}
            </p>

            <a href="{{ action('Web\SelfServiceController@createPasscode') }}" class="btn btn-primary btn-xs mb-1">
                {{ __('Select') }}
            </a>
        </div>
    </div>
</div>
<div class="col-12 col-md-6 col-lg-4">
    <div class="card card-border border-dark shadow-lg mb-6 mb-md-8 mb-lg-0 lift lift-lg">
        <div class="card-body text-center">
            <div class="icon-circle bg-dark text-white mb-5">
                <i class="fe fe-message-circle"></i>
            </div>

            <h4 class="font-weight-bold">
                {{ __('Create a help request')}}
            </h4>

            <p class="text-gray-700 mb-5">
                {{ __('Do you need help from us? Please use this category.')}}
            </p>

            <a href="{{ action('Web\TicketController@create') }}" class="btn btn-primary btn-xs mb-1">
                {{ __('Select') }}
            </a>
        </div>
    </div>
</div>
<div class="col-12 col-md-6 col-lg-4">
    <div class="card card-border border-dark shadow-lg mb-6 mb-md-8 mb-lg-0 lift lift-lg">
        <div class="card-body text-center">
            <div class="icon-circle bg-danger text-white mb-5">
                <i class="fe fe-alert-circle"></i>
            </div>

            <h4 class="font-weight-bold">
                {{ __('Report a problem')}}
            </h4>

            <p class="text-gray-700 mb-5">
                {{ __('Use this category if you are experiencing a problem.')}}
            </p>

            <a href="{{ action('Web\TicketController@create') }}" class="btn btn-primary btn-xs mb-1">
                {{ __('Select') }}
            </a>
        </div>
    </div>
</div>
<div class="col-12 col-md-6 col-lg-4">
    <div class="card card-border border-dark shadow-lg mb-6 mb-md-8 mb-lg-0 lift lift-lg">
        <div class="card-body text-center">
            <div class="icon-circle bg-success text-white mb-5">
                <i class="fe fe-message-circle"></i>
            </div>

            <h4 class="font-weight-bold">
                {{ __('Suggest a new feature')}}
            </h4>

            <p class="text-gray-700 mb-5">
                {{ __("Do you have the next great idea? We can't wait!")}}
            </p>

            <a href="{{ action('Web\TicketController@create') }}" class="btn btn-primary btn-xs mb-1">
                {{ __('Select') }}
            </a>
        </div>
    </div>
</div>
