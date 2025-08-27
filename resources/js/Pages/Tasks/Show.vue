<template>
  <ul class="space-y-4">
    <li v-for="task in project.tasks" :key="task.id" class="p-4 border rounded-md hover:bg-gray-50 space-y-1">
      <div class="flex justify-between items-center">
        <p class="font-medium text-gray-800">{{ task.title }}</p>
        <span class="text-xs rounded px-2 py-1" :class="{
          'bg-yellow-100 text-yellow-800': task.status === 'todo',
          'bg-blue-100 text-blue-800': task.status === 'in_progress',
          'bg-green-100 text-green-800': task.status === 'done',
        }">
          {{ task.status }}
        </span>
      </div>

      <div class="flex gap-2 mt-2">
        <Link :href="route('tasks.edit', [project.id, task.id])" class="text-indigo-600 hover:underline text-sm">
        Edit
        </Link>
        <Link as="button" method="delete" :href="route('tasks.destroy', [project.id, task.id])"
          class="text-red-600 hover:underline text-sm">
        Delete
        </Link>
      </div>
    </li>
  </ul>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  project: {
    type: Object,
    required: true
  }
});
</script>
