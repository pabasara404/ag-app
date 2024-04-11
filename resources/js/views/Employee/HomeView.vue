<template>

  <h1>Employee</h1>
  <n-carousel
    autoplay
    :direction="horizontal"
    :show-arrow="true"
    :dot-type="line"
    :dot-placement="placement"
  >
    <img
      class="carousel-img"
      src="https://naive-ui.oss-cn-beijing.aliyuncs.com/carousel-img/carousel1.jpeg"
    >
    <img
      class="carousel-img"
      src="https://naive-ui.oss-cn-beijing.aliyuncs.com/carousel-img/carousel2.jpeg"
    >
    <img
      class="carousel-img"
      src="https://naive-ui.oss-cn-beijing.aliyuncs.com/carousel-img/carousel3.jpeg"
    >
    <img
      class="carousel-img"
      src="https://naive-ui.oss-cn-beijing.aliyuncs.com/carousel-img/carousel4.jpeg"
    >
  </n-carousel>
</template>

<script setup>
</script>

<style scoped>
.carousel-img {
  width: 100%;
  height: 630px;
  object-fit: cover;
}
</style>
