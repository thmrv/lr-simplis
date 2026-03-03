<template>
  <div class="media-wrapper w-max h-max block">
    <img v-if="props.type == 0" src="props.path" alt="props.alt" :height="{'auto' : props.autoRatio}">
    <video v-if="props.type == 1" src="props.path" alt="props.alt" :height="{'auto' : props.autoRatio}" autoplay="props.autoplay"></video>
  </div>
</template>
<script setup>
const props = defineProps({
  path: { type: String, default: "" },
  alt: { type: String, default: "" },
  autoplay: { type: Boolean, default: false },
  type: { type: Number, default: 0 }, // 0 - image, 1 - video
  autoRatio: { type: Boolean, default: true },
})
</script>