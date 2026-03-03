<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'

const props = defineProps({
  ease: { type: Number, default: 0.5 },
  maxScale: { type: Number, default: 1 },
  minScale: { type: Number, default: 0.25 },
  text: String,
  color: String,
  background: String
})

const targetScale = ref(props.maxScale)
const currentScale = ref(props.maxScale)
const scrollProgress = ref(0)
let rafId = null

const isMinScaleReached = computed(() => scrollProgress.value >= props.threshold)

const handleScroll = () => {
  // 1. Calculate scroll progress (0 to 1)
  const scrollTop = window.scrollY
  const docHeight = document.documentElement.scrollHeight - window.innerHeight
  const progress = Math.min(Math.max(scrollTop / docHeight, 0), 1)
  
  scrollProgress.value = progress
  // 2. Map progress to decreasing scale
  // As progress goes from 0 -> 1, scale goes from maxScale -> minScale
  targetScale.value = props.maxScale - (progress * (props.maxScale - props.minScale))
}

const animate = () => {
  // 3. Smoothly LERP the current scale toward the target
  const diff = targetScale.value - currentScale.value
  currentScale.value += diff * props.ease

  rafId = requestAnimationFrame(animate)
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true })
  handleScroll() // Initialize
  rafId = requestAnimationFrame(animate)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  cancelAnimationFrame(rafId)
})
</script>

<template>
  <div class="text-trackable-outer h-100 p-8 flex flex-col justify-between min-h-screen gap-y-12 bg-acidgreen items-center justify-center overflow-hidden" :class="{ 'bg-dark font-black': isMinScaleReached, 'bg-cyan font-white': !isMinScaleReached }">
    <div class="relative inset-0 flex items-center justify-center pointer-events-none">
      <h1 class="leading-50 break-words whitespace-wrap text-center font-black will-change-transform text-trackable text-10xl uppercase" :style="{
        transform: `scale(${currentScale})`,
        color: props.color
      }">
      {{ props.text}}
      </h1>
    </div>

  </div>
</template>