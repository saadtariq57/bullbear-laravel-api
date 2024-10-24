<template>
  <div class="modal-dialog login-popup-dialog modal-dialog-centered">
    <div class="modal-content position-relative">
      <button type="button" class="btn-close position-absolute login-popup-closebtn" data-bs-dismiss="modal"
        aria-label="Close" @click="$emit('close')"></button>
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
                <input type="email" class="form-control" id="Username" v-model="email" placeholder="Enter Your Email">
              </div>
              <div class="mb-3">
                <label for="Password" class="form-label">Password</label>
                <input type="password" class="form-control" id="Password" v-model="password" placeholder="Enter Password">
              </div>
              <button type="submit" class="btn btn-primary w-100 py-3 fs-5">Login</button>
              <div class="d-sm-flex justify-content-between mt-3">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="rememberDevice" v-model="rememberDevice">
                  <label class="form-check-label" for="rememberDevice">Remember this device</label>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
import Swal from 'sweetalert2';

export default {
  name: 'LoginPopup',
  emits: ['close'],
  setup(props, { emit }) {
    const store = useStore();
    const router = useRouter();
    const email = ref('');
    const password = ref('');
    const rememberDevice = ref(false);

    const login = async () => {
      try {
        const result = await store.dispatch('login', {
          email: email.value,
          password: password.value,
          remember: rememberDevice.value
        });

        if (result.success) {
          emit('close');
          Swal.fire({
            icon: 'success',
            title: 'Logged in successfully',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          if (result.redirect) {
            window.location.href = result.redirect;
          } else {
            router.push('/feed');
          }
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Login failed',
            text: result.message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
        }
      } catch (error) {
        console.error('Login error:', error);
        Swal.fire({
          icon: 'error',
          title: 'Login failed',
          text: 'An unexpected error occurred',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
      }
    };

    return {
      email,
      password,
      rememberDevice,
      login
    };
  }
};
</script>