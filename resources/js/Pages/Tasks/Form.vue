<template>
    <form @submit.prevent="submit" class="space-y-6">
      <div>
        <label class="block text-sm font-medium text-gray-700">Title</label>
        <input v-model="form.title" type="text" class="mt-1 block w-full border rounded-md" />
        <div v-if="form.errors.title" class="text-sm text-red-600">{{ form.errors.title }}</div>
      </div>
  
      <div>
        <label class="block text-sm font-medium text-gray-700">Description</label>
        <textarea v-model="form.description" class="mt-1 block w-full border rounded-md"></textarea>
      </div>
  
      <div>
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <select v-model="form.status" class="mt-1 block w-full border rounded-md">
          <option value="todo">To Do</option>
          <option value="in_progress">In Progress</option>
          <option value="done">Done</option>
        </select>
      </div>
  
      <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500">
        {{ form.processing ? 'Saving...' : buttonText }}
      </button>
    </form>
  </template>
  
  <script setup>
  import { useForm } from '@inertiajs/vue3';
  const props = defineProps({ task: Object, action: String, buttonText: String });
  
  const form = useForm({
    title: props.task?.title || '',
    description: props.task?.description || '',
    status: props.task?.status || 'todo',
  });
  
  const submit = () => {
    props.action === 'update'
      ? form.put(`/projects/${props.task.project_id}/tasks/${props.task.id}`)
      : form.post(`/projects/${props.task.project_id}/tasks`);
  };
  </script>
  