<template>
  <div class="loading-shutter-outer fixed w-full bg-white m-0 z-50">
    <div class="loading-shutter w-full bg-default m-0" :class="{ 'loading-shutter-animation': isReady }">
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'

const isReady = ref(false)

onMounted(() => {
    isReady.value = true
})

defineProps({
  tag: { type: String, default: 'span' },
  delay: { type: String, default: '0s' },
  extraClasses: { type: String, default: '' }
});
</script>

<style scoped>
.loading-shutter {
  display: block;
  /* Adjust the bezier for that high-end 'Neue Montreal' feel */
  will-change: transform;
}

.loading-shutter-animation {
  animation: loading-shutter .25s ease-in;
}

.loading-shutter-outer {
  top: 0px;
}

@keyframes loading-shutter {
  from {
    height: 100vh;
  }

  to {
    height: 0vh;
  }
}
</style>