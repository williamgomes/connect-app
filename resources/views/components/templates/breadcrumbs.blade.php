<div class="header mt-md-5">
    <div class="header-body">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="header-pretitle">
                    {{ $pretitle }}
                </h6>
                <h1 class="header-title">
                    {{ $title }}
                </h1>
                @isset ($subtitle)
                    {{ $subtitle }}
                @endisset
            </div>
            @isset ($rightContent)
                <div class="col-auto">
                    {{ $rightContent }}
                </div>
            @endisset
        </div>
        {{ $slot }}
    </div>
</div>
