<template>
    <div class="modal fade" v-bind:id="data.modalId" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    v-bind:aria-labelledby="data.modalId + 'Label'" v-if="showModal">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" v-bind:id="data.modalId + 'Label'">{{ data.title }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            {{ data.body }}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary border-btn" data-bs-dismiss="modal" @click="closeModal('close')">DON’T DELETE</button>
            <button type="button" class="btn btn-primary"
            data-bs-dismiss="modal" @click="closeModal('confirm')">DELETE</button>
        </div>
        </div>
    </div>
</div>
</template>

<script>
import Confirm from "./confirm.js";

export default Confirm;
</script>
