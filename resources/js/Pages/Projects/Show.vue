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


          <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-800 mb-3">Add New Task</h3>
            <form @submit.prevent="submit">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm text-gray-700">Title</label>
                  <input v-model="form.title" type="text" class="mt-1 w-full border rounded-md" />
                  <div v-if="form.errors.title" class="text-sm text-red-600 mt-1">
                    {{ form.errors.title }}
                  </div>
                </div>
                <div>
                  <label class="block text-sm text-gray-700">Status</label>
                  <select v-model="form.status" class="mt-1 w-full border rounded-md">
                    <option value="todo">To Do</option>
                    <option value="in_progress">In Progress</option>
                    <option value="done">Done</option>
                  </select>
                </div>
              </div>
              <div class="mt-4">
                <label class="block text-sm text-gray-700">Description</label>
                <textarea v-model="form.description" rows="3" class="w-full border rounded-md"></textarea>
              </div>
              <div class="mt-4 text-right">
                <button type="submit"
                  class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500">
                  + Add Task
                </button>
              </div>
            </form>
          </div>



          <h3 class="text-lg font-medium text-gray-800 mb-3">Tasks</h3>

          <ul v-if="project.tasks.length > 0" class="space-y-2">
            <li v-for="task in project.tasks" :key="task.id" class="p-4 border rounded-md hover:bg-gray-50">
              <div class="flex justify-between items-center">
                <Link :href="route('tasks.edit', [project.id, task.id])"
                  class="font-medium text-gray-800 hover:underline">
                {{ task.title }}
                </Link>
                <span class="text-xs rounded px-2 py-1" :class="{
                  'bg-yellow-100 text-yellow-800': task.status === 'todo',
                  'bg-blue-100 text-blue-800': task.status === 'in_progress',
                  'bg-green-100 text-green-800': task.status === 'done',
                }">
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
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({ project: Object });

const form = useForm({
  title: '',
  description: '',
  status: 'todo',
});

const submit = () => {
  form.post(route('tasks.store', props.project.id), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
  });
};


</script>
