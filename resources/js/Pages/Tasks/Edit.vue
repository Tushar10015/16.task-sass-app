<template>
    <AppLayout :title="`Edit Task - ${task.title}`">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800">Edit Task</h2>
      </template>
  
      <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <Form :task="task" :button-text="'Update Task'" action="update" />
      </div>
    </AppLayout>
  </template>
  
  <script setup>
  import AppLayout from '@/Layouts/AppLayout.vue';
  import Form from './Form.vue';
  defineProps({ task: Object, project: Object });
  </script>
  