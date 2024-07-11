<template>
  <div class="modal fade show" id="login-popup" tabindex="-1" aria-labelledby="login-popupLabel" aria-hidden="true" style="display: block;">
    <div class="modal-dialog login-popup-dialog modal-dialog-centered">
      <div class="modal-content position-relative">
        <button type="button" class="btn-close position-absolute login-popup-closebtn" @click="closePopup" aria-label="Close"></button>
        <div class="modal-body row p-0">
          <div class="col-lg-4 d-xl-flex d-none align-items-end" style="background-color: #EAECF4;">
            <div class="login-men">
              <img src="/build/images/man.png" alt="men">
            </div>
          </div>
          <div class="col-xl-8">
            <div class="login-popup-wrapper">
              <h2 class="fs-2">RICH TV ACCOUNT LOGIN</h2>
              <p>Not a member? <a href="/register" class="fw-medium text-primary">Create Account</a></p>
              <hr class="Red border-2">
              <form @submit.prevent="login">
                <div class="mb-3">
                  <label for="Username" class="form-label">Username</label>
                  <input type="email" class="form-control" id="Username" v-model="email" placeholder="Enter Your Email" required>
                </div>
                <div class="mb-3">
                  <label for="Password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="Password" v-model="password" placeholder="Enter Password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-3 fs-5">Login</button>
                <div class="d-sm-flex justify-content-between mt-3">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rememberDevice" v-model="rememberDevice">
                    <label class="form-check-label" for="rememberDevice">Remember this device</label>
                  </div>
                  <div>
                    <a href="/password/reset">Forgot Password?</a>
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
  data() {
    return {
      email: '',
      password: '',
      rememberDevice: false
    }
  },
  methods: {
    async login() {
      try {
        const response = await this.$store.dispatch('login', {
          email: this.email,
          password: this.password,
          remember: this.rememberDevice
        });
        if (response.success) {
          this.$store.commit('SET_SHOW_LOGIN_POPUP', false);
          // Redirect to the originally requested page
          this.$router.push(this.$route.query.redirect || '/feed');
        } else {
          // Handle login error
          alert(response.message);
        }
      } catch (error) {
        console.error('Login error:', error);
        alert('An error occurred during login');
      }
    },
    closePopup() {
      this.$store.commit('SET_SHOW_LOGIN_POPUP', false);
    }
  }
}
</script>