<template>
  <div class="overflow-hidden py-1"> <!-- py-1 prevents clipping of descenders -->
    <component 
      :is="tag"
      class="shutter-text"
      :class="extraClasses"
      :style="{ animationDelay: delay }"
    >
      <slot />
    </component>
  </div>
</template>

<script setup lang="ts">
defineProps({
  tag: { type: String, default: 'span' },
  delay: { type: String, default: '0s' },
  extraClasses: { type: String, default: '' }
});
</script>

<style scoped>
.shutter-text {
  display: block;
  /* Adjust the bezier for that high-end 'Neue Montreal' feel */
  animation: rolling-shutter 1.1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  transform: translateY(110%); 
  will-change: transform;
}

@keyframes rolling-shutter {
  from { transform: translateY(110%); }
  to { transform: translateY(0); }
}
</style>