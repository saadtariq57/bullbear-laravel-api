<template>
    <div class="header_login d-flex gap-4 justify-content-end align-items-center">
        <a href="/login" class="d-flex gap-2 fs-16 fw-bolder nav-clr" aria-label="login"><i
                class="bi bi-box-arrow-in-right"></i>LOG IN</a>
        <a href="/register" class="d-flex gap-2 fs-16 fw-bolder nav-clr" aria-label="signup"><i
                class="bi bi-person-fill"></i>SIGN UP</a>
    </div>
</template>
<style>
.header_login a{
    padding: 16px 0;
}

@media (max-width: 400px) {
    .nav-clr{
        font-size: 12px !important;
    }
    .header_login{
        gap: 15px !important;
    }
}
</style>