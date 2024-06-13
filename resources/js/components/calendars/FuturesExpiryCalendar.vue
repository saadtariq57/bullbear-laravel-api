<template>
 <div class="container my-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-5 border-bottom">
                        <h1 class="fs-1 fw-bold icon-heading">Futures Expiry Calendar</h1>
                    </div>
                    <div class="expiry">
                        <CalenderData />
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
import Markets from '../widgets/Markets.vue';
import LatestArticles from '../widgets/LatestArticles.vue';
import CalenderData from "./CalenderData.vue";
export default {
    components: {
        LatestArticles,
        Markets,
        CalenderData
    },
}
</script>