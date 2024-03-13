<template>
  <section class="stock-quote container-fluid py-80 bg-smoke" id="stock-quote">
    <div class="container">
      <div class="row justify-content-center gy-5">
        <GroupChats />
        <MarketAnalysis />
        <FinancialNews />
      </div>
    </div>
  </section>
</template>
<script>
  import GroupChats from "../widgets/GroupChats.vue";
  import MarketAnalysis from "../widgets/MarketAnalysis.vue";
  import FinancialNews from "../widgets/FinancialNews.vue";
  export default {
    components: {
      GroupChats,
      MarketAnalysis,
      FinancialNews,
    },
};
</script>