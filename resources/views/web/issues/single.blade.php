<div class="row">
    <div class="col-12 col-md-4">
        <dl class="row mb-0">
            <dt class="col-auto">{{ __('Title') }}:</dt>
            <dd class="text-black-50">
                {{ $issue->title }}
            </dd>
        </dl>
    </div>

    <div class="col-12 col-md-4">
        <dl class="row mb-0">
            <dt class="col-auto">{{ __('Type') }}:</dt>
            <dd class="text-black-50">
                @if($issue->type == \App\Models\Issue::TYPE_BUG)
                    <span class="badge badge-danger">{{ __('Bug') }}</span>
                @elseif($issue->type == \App\Models\Issue::TYPE_FEATURE)
                    <span class="badge badge-primary">{{ __('Feature') }}</span>
                @endif
            </dd>
        </dl>
    </div>

    <div class="col-12 col-md-4">
        <dl class="row mb-0">
            <dt class="col-auto">{{ __('Status') }}:</dt>
            <dd class="text-black-50">
                @if($issue->status == \App\Models\Issue::STATUS_AWAITING_SPECIFICATION)
                    <span class="badge badge-warning">{{ __('Awaiting Specification') }}</span>
                @elseif($issue->status == \App\Models\Issue::STATUS_BACKLOG)
                    <span class="badge badge-dark">{{ __('Backlog') }}</span>
                @elseif($issue->status == \App\Models\Issue::STATUS_DECLINED)
                    <span class="badge badge-danger">{{ __('Declined') }}</span>
                @elseif($issue->status == \App\Models\Issue::STATUS_DONE)
                    <span class="badge badge-success">{{ __('Done') }}</span>
                @elseif($issue->status == \App\Models\Issue::STATUS_IN_PROGRESS)
                    <span class="badge badge-primary">{{ __('In progress') }}</span>
                @elseif($issue->status == \App\Models\Issue::STATUS_QUALITY_ASSURANCE)
                    <span class="badge badge-secondary">{{ __('Quality Assurance') }}</span>
                @endif
            </dd>
        </dl>
    </div>
</div>

<hr>

<p class="mt-4">
    {!! $issue->description !!}
</p>
