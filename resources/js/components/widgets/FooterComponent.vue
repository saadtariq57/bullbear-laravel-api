<template>
  <div>
    <div class="border-bottom">
      <p class="fs-13 text-secondary my-1">© 2024 Rich Tv</p>
    </div>
    <ul class="d-flex justify-content-between align-items-center list-unstyled mt-2">
      <li><a href="/about-us" class="fs-13 text-secondary">About</a></li>
      <li><a href="/contact-us" class="fs-13 text-secondary">Contact Us</a></li>
      <li>
        <div class="btn-group">
          <button type="button" class="btn bg-transparent dropdown-toggle border-0 fs-13 text-secondary"
            data-bs-toggle="dropdown" aria-expanded="false" @click="toggleDropdown($event)">
            More
          </button>
          <ul class="dropdown-menu text-uppercase">
            <li class="px-2 py-1"><a href="/privacy-policy" class="text-black">Privacy Policy</a></li>
            <li class="px-2 py-1"><a href="/terms-of-use" class="text-black">Terms of use</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import { Dropdown } from 'bootstrap';

export default {
  name: 'FooterComponent',
  methods: {
    toggleDropdown(event) {
      const dropdownElement = event.target.closest('.dropdown-toggle');
      const dropdownInstance = Dropdown.getOrCreateInstance(dropdownElement);
      dropdownInstance.toggle();
    },
  },
};
</script>

<style scoped>
/* Add any specific styles if necessary */
</style>
