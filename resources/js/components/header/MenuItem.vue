<template>
    <li>
        <div v-if="menuItem.children && menuItem.children.length > 0" class="dropdown d-flex gap-2 align-items-center">
            <button class="nav-link dropdown-toggle d-flex nav-clr" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <span class="clr-primary">{{ menuItem.title }}</span>
            </button>
            <img src="/build/images/bxs_up-arrow.png" alt="" width="15px" height="15px" class="dropdown-img">
            <ul class="dropdown-menu px-4 py-3 mega-menu-dropdown">
                <MenuItem v-for="child in menuItem.children" :key="child.id" :menuItem="child" />
            </ul>
        </div>
        <div v-else>
            <router-link :to="menuItem.url" class="dropdown-item nav-link">{{ menuItem.title }}</router-link>
        </div>
    </li>
</template>

<script>
export default {
    name: 'MenuItem',
    props: {
        menuItem: {
            type: Object,
            required: true,
        },
    },
    components: {
        MenuItem: () => import('./MenuItem.vue'),
    },
};
</script>

<style scoped>
/* Add your styles here if needed */
</style>