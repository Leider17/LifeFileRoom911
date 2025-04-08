<template>
    <div v-if="links.length > 3" class="flex justify-center mt-4 space-x-1">
      <template v-for="(link, key) in links" :key="key">
        <button
          v-if="link.url"
          :class="[
            'px-3 py-1 rounded-md text-sm',
            link.active ? 'bg-blue-600 text-white' : 'bg-white border text-gray-700 hover:bg-gray-100',
          ]"
          @click="$inertia.visit(link.url)"
          v-html="link.label"
        />
        <span
          v-else
          class="px-3 py-1 rounded-md text-sm text-gray-400"
          v-html="link.label"
        />
      </template>
    </div>
  </template>

  <script setup>
  defineProps({
    links: {
      type: Array,
      required: true,
    },
  });
  </script>
