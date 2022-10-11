<div class="avatar avatar-xxl header-avatar-top account-img">
    <img src="{{ Storage::disk('s3')->temporaryUrl('images/profile/' . $user->profile_picture, now()->addMinutes(5)) }}" class="avatar-img rounded-circle border border-4 border-body" title="{{ __('Click to upload profile picture') }}" onclick="$('#profile_picture').click()">
    <span class="fe fe-refresh-cw account-img-update" onclick="$('#profile_picture').click()"></span>
</div>

@include('app.users.modals.crop-image')
