@extends('layouts.auth')
@section('title', 'Admin Login')

@section('content')
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="{{ asset('assets/images/logo.svg') }}">
                </div>
                <h6 class="font-weight-light">Verification de code</h6>
                <form class="pt-3" method="POST" action="{{BASE_PATH}}/admin/verify-code">
                  <div class="form-group">
                    <input type="hidden" name="email" class="form-control form-control-lg" value="{{ $email }}">
                  </div>
                  <div class="form-group">
                    <input type="text" name="verify_code" class="form-control form-control-lg" placeholder="Code de verification">
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">VERRIFIER</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
@endsection