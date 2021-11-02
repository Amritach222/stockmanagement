<template>
  <CFooter :fixed="false">
    <div>
      <a href="https://rkdrealestate.com.np" target="_blank">StockManagement</a>
      <span class="ml-1">&copy; {{new Date().getFullYear()}} RKD Holdings.</span>
    </div>
    <div class="mfs-auto">
      <span class="mr-1" target="_blank">Powered by</span>
      <a href="https://rkdrealestate.com.np">RKD Inhouse</a>
    </div>
  </CFooter>
</template>

<script>
export default {
  name: 'Footers'
}
</script>
