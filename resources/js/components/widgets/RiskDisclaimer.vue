<template>
  <div class="risk-disclaimer border-primary pt-4 pb-2 px-3 border mb-2 rounded-1">
    <h1 class="fw-6 fs-5 text-secondary">
      <img src="/build/images/alert-icon.png" alt="" width="20" height="20"
        class="align-top">
      RISK DISCLAIMER!
    </h1>
    <p class="fs-14 text-black">
      Stock market investing is inherently risky. Rich Tv is not responsible for any gains or losses that result from the opinions expressed on this website,
      in its research reports, company profiles or in other investor relations materials or presentations that it publishes electronically or in print.
      We strongly encourage all investors to conduct their own research before making any investment decision. For more information on stock market
      investing, visit the Securities and Exchange Commission ("SEC") at www.sec.gov.
    </p>
  </div>
</template>

<script>
export default {
  name: 'RiskDisclaimer',
};
</script>

<style scoped>
.risk-disclaimer {
  background-color: #ffb8001a;
  width: 100%;
  box-sizing: border-box;
}
</style>
