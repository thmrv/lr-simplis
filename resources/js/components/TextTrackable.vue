<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  ease: { type: Number, default: 0.08 },
  range: { type: Number, default: 200 },
  text: String,
  color: String
})

const targetX = ref(-props.range)
const currentX = ref(-props.range)
let rafId = null

const handleScroll = () => {
  const scrollTop = window.scrollY
  const docHeight = document.documentElement.scrollHeight - window.innerHeight
  const scrollPercent = Math.min(Math.max(scrollTop / docHeight, 0), 1)

  targetX.value = props.range - (scrollPercent * (props.range * 2))
}

const animate = () => {
  const diff = targetX.value - currentX.value
  currentX.value += diff * props.ease

  rafId = requestAnimationFrame(animate)
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true })
  handleScroll()
  rafId = requestAnimationFrame(animate)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  cancelAnimationFrame(rafId)
})
</script>

<template>
  <div class="text-trackable-outer">
    <div class="relative inset-0 flex items-center justify-center pointer-events-none">
      <h1 class="leading-tight whitespace-nowrap will-change-transform text-trackable text-12xl uppercase" :style="{
        transform: `translateX(${currentX}px)`,
        color: `${props.color}`
      }">
      {{ props.text}}
      </h1>
    </div>

  </div>
</template>