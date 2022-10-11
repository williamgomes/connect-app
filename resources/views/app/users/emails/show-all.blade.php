<table class="table table-sm card-table">
    <thead>
        <tr>
            <th>{{ __('From') }}</th>
            <th>{{ __('To') }}</th>
            <th>{{ __('Subject') }}</th>
            <th>{{ __('Date') }}</th>
            <th class="text-right">
                {{ __('Actions') }}
            </th>
        </tr>
    </thead>
    <tbody class="list">
        @forelse($user->emails as $email)
            <tr>
                <td>
                    {{ $email->from_name }} ({{ $email->from }})
                </td>
                <td>
                    {{ $email->to }}
                </td>
                <td>
                    <a href="{{ action('App\UserEmailController@show', [$user, $email]) }}">
                        {{ $email->subject }}
                    </a>
                </td>
                <td>
                    {{ $email->created_at->format('Y-m-d') }}
                </td>
                <td class="text-right">
                    <div class="dropdown">
                        <a href="#!" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fe fe-more-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ action('App\UserEmailController@show', [$user, $email]) }}" class="dropdown-item">
                                {{ __('View') }}
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">
                    <i class="m-auto text-muted">{{ __('No incoming emails yet') }}</i>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>