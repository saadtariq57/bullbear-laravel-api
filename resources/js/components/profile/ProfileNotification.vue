<template>
  <div class="container mt-2 mb-4">
  <div class="row">
  <div class="col-lg-8 mt-3">
    <div class="bg-white shadow">
      <div class="border-bottom p-3 ">
      <h2 class="mb-0 fs-4 fw-6">All Notifications</h2>
    </div>
      <div class="list-group">

        <a href="#"
          class="list-group-item list-group-item-action px-4 py-3 d-flex align-items-center gap-3 border-bottom position-relative unread-notification-wrapper">
          <div class="unread-notification"></div>
          <img  src="/build/images/brands/cryptocurrency_btc.png" alt="" width="30" height="30">
          <div class="flex-fill">
            <h6 class="text-uppercase fs-6 fw-6 clr-primary">Bitcoin</h6>
            <p class="text-uppercase mb-0 fs-6 fw-4 text-wrap">bitcoin recently just hit 31k on
              bullish
              sentiment
            </p>
          </div>
          <div class="fs-6 fw-5 text-center">
            <span class="d-block">25w</span>
            <div class="btn-group"><button type="button" class="bg-transparent border-0 p-0 dropdown-toggle"
                data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" @click="toggleDropdown($event)"><i
                  class="bi bi-three-dots fs-4"></i></button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><button class="dropdown-item" type="button"><i class="bi bi-check2-all me-2 fs-5"></i>Mark as read</button></li>
                <li><button class="dropdown-item" type="button"><i class="bi bi-trash me-2"></i>Delate notification</button></li>
                <li><button class="dropdown-item" type="button"><i class="bi bi-bell-slash-fill me-2"></i>Turn off notifications about Hanzala Sardar</button></li>
              </ul>
            </div>
          </div>
        </a>
        <a href="#"
          class="list-group-item list-group-item-action px-4 py-3 d-flex align-items-center gap-3 border-bottom position-relative"><img
            src="/build/images/brands/cryptocurrency_btc.png" alt="" width="30" height="30">
          <div class="flex-fill">
            <h6 class="text-uppercase fs-6 fw-6 clr-primary">Bitcoin</h6>
            <p class="text-uppercase mb-0 fs-6 text-wrap">bitcoin recently just hit 31k on
              bullish
              sentiment
            </p>
          </div>
          <div class="fs-6 fw-5 text-center">
            <span class="d-block">25w</span>
            <div class="btn-group"><button type="button" class="bg-transparent border-0 p-0 dropdown-toggle"
                data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" @click="toggleDropdown($event)"><i
                  class="bi bi-three-dots fs-4"></i></button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><button class="dropdown-item" type="button"><i class="bi bi-trash me-2"></i>Delate notification</button></li>
                <li><button class="dropdown-item" type="button"><i class="bi bi-bell-slash-fill me-2"></i>Turn off notifications about Hanzala Sardar</button></li>
              </ul>
            </div>
          </div>
        </a>
        <a href="#"
          class="list-group-item list-group-item-action px-4 py-3 d-flex align-items-center gap-3 border-bottom position-relative"><img
            src="/build/images/brands/cryptocurrency_btc.png" alt="" width="30" height="30">
          <div class="flex-fill">
            <h6 class="text-uppercase fs-6 fw-6 clr-primary">Bitcoin</h6>
            <p class="text-uppercase mb-0 fs-6 text-wrap">bitcoin recently just hit 31k on
              bullish
              sentiment
            </p>
          </div>
          <div class="fs-6 fw-5 text-center">
            <span class="d-block">25w</span>
            <div class="btn-group"><button type="button" class="bg-transparent border-0 p-0 dropdown-toggle"
                data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false" @click="toggleDropdown($event)"><i
                class="bi bi-three-dots fs-4"></i></button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><button class="dropdown-item" type="button"><i class="bi bi-trash me-2"></i>Delate notification</button></li>
                <li><button class="dropdown-item" type="button"><i class="bi bi-bell-slash-fill me-2"></i>Turn off notifications about Hanzala Sardar</button></li>
            </ul>
          </div>
        </div>
      </a>
      <a href="#"
        class="list-group-item list-group-item-action px-4 py-3 d-flex align-items-center gap-3 border-bottom unread-notification-wrapper position-relative">
        <div class="unread-notification"></div>
        <img src="/build/images/brands/cryptocurrency_btc.png" alt="" width="30" height="30">
        <div class="flex-fill">
          <h6 class="text-uppercase fs-6 fw-6 clr-primary">Bitcoin</h6>
          <p class="text-uppercase mb-0 fs-6 text-wrap">bitcoin recently just hit 31k on
            bullish
            sentiment
          </p>
        </div>
        <div class="fs-6 fw-5 text-center">
          <span class="d-block">25w</span>
          <div class="btn-group"><button class="bg-transparent border-0 p-0 dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false"
            @click="toggleDropdown($event)"><i
                class="bi bi-three-dots fs-4"></i></button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><button class="dropdown-item" type="button"><i class="bi bi-check2-all me-2 fs-5"></i>Mark as read</button></li>
              <li><button class="dropdown-item" type="button"><i class="bi bi-trash me-2"></i>Delate notification</button></li>
                <li><button class="dropdown-item" type="button"><i class="bi bi-bell-slash-fill me-2"></i>Turn off notifications about Hanzala Sardar</button></li>
            </ul>
          </div>
        </div>
      </a>
    </div>
    <!-- no notification found case -->
    <div class="list-group d-flex justify-content-center align-items-center empty-notification-wrapper">
      <div class="text-center">
        <i class="bi bi-bell fs-1"></i>
        <h3>No Notifications Yet</h3>
        <p>When you get notifications, they'll show up here</p>
      </div>
    </div>
  </div>
</div>
<div class="col-lg-4">
  <Markets />
  <LatestArticles />
</div>
</div>
</div>
</template>
<script>
import { Dropdown } from 'bootstrap';
import Markets from '../widgets/Markets.vue';
import LatestArticles from '../widgets/LatestArticles.vue'
export default{
  components: {
        LatestArticles,
        Markets
    },
  methods: {
        toggleDropdown(event) {
            const dropdownElement = event.target.closest('.dropdown-toggle');
            const dropdownInstance = Dropdown.getOrCreateInstance(dropdownElement);
            dropdownInstance.toggle();
        },
      }
    }
</script>
<style>
.list-group-item-action:hover {
  background-color: #cfcfcf42;
}
.unread-notification-wrapper{
  background-color: #C3DDF8;
}
.unread-notification-wrapper:hover{
  background-color: #aed3fa;
}
.unread-notification{
  width: 10px;
  height: 10px;
  background-color: #EDB043;
  border-radius: 50%;
  position: absolute;
  left: 7px;
}
.empty-notification-wrapper{
  height: 70vh;
}
</style>