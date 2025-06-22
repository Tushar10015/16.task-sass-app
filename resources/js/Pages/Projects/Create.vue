<template>
  <AppLayout title="Create Project">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Project
      </h2>
    </template>

    <div class="py-6">
      <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

        <form @submit.prevent="submit" class="bg-white shadow rounded-lg p-6 space-y-6">

          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">
              Project Name
            </label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            />
            <div v-if="form.errors.name" class="text-sm text-red-600 mt-1">
              {{ form.errors.name }}
            </div>
          </div>

          <div>
            <label for="description" class="block text-sm font-medium text-gray-700">
              Description
            </label>
            <textarea
              id="description"
              v-model="form.description"
              rows="4"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            ></textarea>
            <div v-if="form.errors.description" class="text-sm text-red-600 mt-1">
              {{ form.errors.description }}
            </div>
          </div>

          <div class="flex justify-end">
            <button
              type="submit"
              class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-500 transition"
            >
              Create
            </button>
          </div>

        </form>

      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  description: '',
});

const submit = () => {
  form.post('/projects');
};
</script>
