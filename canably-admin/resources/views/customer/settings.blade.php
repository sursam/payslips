@extends('customer.layouts.app', ['navbar' => true, 'sidebar' => true, 'footer' => false])
@push('style')
@endpush
@section('content')
    <h2>Settings</h2>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="c-password" data-bs-toggle="tab" data-bs-target="#cpass" type="button"
                role="tab" aria-controls="cpass" aria-selected="true">Change Password</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="notification-tab" data-bs-toggle="tab" data-bs-target="#notification"
                type="button" role="tab" aria-controls="notification" aria-selected="false">Notification</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="cpass" role="tabpanel" aria-labelledby="c-password">
            <form class="mt-4 update-password" action="{{ route('customer.change.password') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="old_pass">Old Password</label>
                    <input type="password" name="current_password" class="form-control" id="current_password"
                        placeholder="Old Password">
                    @error('current_password')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="new_pass">New Password</label>
                    <input type="password" name="new_password" class="form-control" id="new_password"
                        placeholder="New Password">
                    @error('new_password')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="conf_pass">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" id="confirm_password"
                        placeholder="Confirm Password">
                    @error('confirm_password')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" class="shop-shop-now default-button" value="Update">
                </div>

            </form>

        </div>


        <div class="tab-pane fade" id="notification" role="tabpanel" aria-labelledby="notification-tab">


            <div class="notifications-settings">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="switch1" />
                    <label class="form-check-label" for="switch1">Lorem ipsum, or lipsum as it is sometimes known</label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="switch2" />
                    <label class="form-check-label" for="switch2">Lorem ipsum, or lipsum as it is sometimes known</label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="switch3" />
                    <label class="form-check-label" for="switch3">Lorem ipsum, or lipsum as it is sometimes known</label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="switch4" />
                    <label class="form-check-label" for="switch4">Lorem ipsum, or lipsum as it is sometimes known</label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="switch5" />
                    <label class="form-check-label" for="switch5">Lorem ipsum, or lipsum as it is sometimes known</label>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
