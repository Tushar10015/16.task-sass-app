<template>
  <AppLayout :title="project.name">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ project.name }}
      </h2>
    </template>

    <div class="py-6">
      <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="bg-white shadow rounded-lg p-6">
          <p class="text-gray-600 text-base">{{ project.description }}</p>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-medium text-gray-800 mb-3">Tasks</h3>

          <ul v-if="project.tasks.length > 0" class="space-y-2">
            <li
              v-for="task in project.tasks"
              :key="task.id"
              class="p-4 border rounded-md hover:bg-gray-50"
            >
              <div class="flex justify-between items-center">
                <p class="font-medium text-gray-800">{{ task.title }}</p>
                <span
                  class="text-xs rounded px-2 py-1"
                  :class="{
                    'bg-yellow-100 text-yellow-800': task.status === 'todo',
                    'bg-blue-100 text-blue-800': task.status === 'in_progress',
                    'bg-green-100 text-green-800': task.status === 'done',
                  }"
                >
                  {{ task.status }}
                </span>
              </div>
            </li>
          </ul>

          <p v-else class="text-gray-500 text-sm">No tasks yet.</p>
        </div>

      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({ project: Object });
</script>
