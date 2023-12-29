<template>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#login-popup">
    Launch Login MOdel
  </button>
  <div class="modal fade" id="login-popup" tabindex="-1" aria-labelledby="login-popupLabel" aria-hidden="true">
    <div class="modal-dialog login-popup-dialog modal-dialog-centered">
      <div class="modal-content position-relative">
        <button type="button" class="btn-close position-absolute login-popup-closebtn" data-bs-dismiss="modal"
          aria-label="Close"></button>
        <div class="modal-body row p-0">
          <div class="col-lg-4 d-xl-flex d-none align-items-end" style="background-color: #EAECF4;">
            <div class="login-men">
              <img src="{{ URL::asset('build/images/man.png') }}" alt="men">
            </div>
          </div>
          <div class="col-xl-8">
            <div class="login-popup-wrapper">
              <h2 class="fs-2">RICH TV ACCOUNT LOGIN</h2>
              <p>Not a member? <a href="{{ route('register') }}" class="fw-medium text-primary">
                  Create Account</a></p>
              <hr class="Red border-2">
              <form>
                <div class="mb-3">
                  <label for="Username" class="form-label">Username</label>
                  <input type="email" class="form-control" id="Username" placeholder="Enter Your Email">
                </div>
                <div class="mb-3">
                  <label for="Password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="Password" placeholder="Enter Password">
                </div>
                <button type="submit" class="btn btn-primary w-100 py-3 fs-5">Login</button>
                <div class="d-sm-flex justify-content-between mt-3">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Remember this device</label>
                  </div>
                  <div>
                    <a href="">Forgot Password?</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {

}
</script>