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
              <!-- Subtasks -->
              <div class="mt-3 space-y-1 pl-4 border-l">
                <form @submit.prevent="submitSubtask(task.id)" class="flex gap-2 mt-2">
                  <input v-model="subtaskForms[task.id]" type="text" placeholder="New subtask..."
                    class="w-full border rounded-md px-2 py-1 text-sm" />
                  <button type="submit" class="text-sm px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-500">
                    Add
                  </button>
                </form>

                <div v-if="task.subtasks.length" class="space-y-1">
                  <div v-for="subtask in task.subtasks" :key="subtask.id" class="flex items-center gap-2">
                    <input type="checkbox" :checked="subtask.is_done" @change="toggleSubtask(subtask.id)"
                      class="rounded border-gray-300 text-indigo-600" />
                    <label :class="{ 'line-through text-gray-500': subtask.is_done }">
                      {{ subtask.title }}
                    </label>
                  </div>
                </div>
                <p v-else class="text-sm text-gray-500">No subtasks</p>
              </div>

              <!-- Comments -->
              <div class="mt-4 pl-4 border-l pt-2 space-y-2">
                <p class="text-sm text-gray-700 font-semibold">Comments</p>
                <div v-for="comment in task.comments" :key="comment.id"
                  class="text-sm bg-gray-50 p-2 rounded-md border">
                  <span class="text-gray-800 font-medium">{{ comment.user.name }}:</span>
                  <span class="text-gray-600">{{ comment.body }}</span>
                  <div class="text-xs text-gray-400 mt-1">{{ formatDate(comment.created_at) }}</div>
                </div>

                <form @submit.prevent="submitComment(task.id)" class="mt-2">
                  <input v-model="commentForms[task.id]" placeholder="Write a comment..."
                    class="w-full border rounded-md px-3 py-1 text-sm" />
                </form>
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
import { useForm, Link, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

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


const commentForms = ref({});

// Format date helper
function formatDate(datetime) {
  return new Date(datetime).toLocaleString();
}

// Toggle subtask done
const toggleSubtask = (subtaskId) => {
  router.put(`/subtasks/${subtaskId}/toggle`, {}, {
    preserveScroll: true,
  });
};

// Submit comment
const submitComment = (taskId) => {
  const body = commentForms.value[taskId];
  if (!body) return;

  router.post(`/tasks/${taskId}/comments`, { body }, {
    preserveScroll: true,
    onSuccess: () => (commentForms.value[taskId] = ''),
  });
};

const subtaskForms = ref({});

const submitSubtask = (taskId) => {
  const title = subtaskForms.value[taskId];
  if (!title) return;

  router.post(`/tasks/${taskId}/subtasks`, { title }, {
    preserveScroll: true,
    onSuccess: () => subtaskForms.value[taskId] = '',
  });
};

onMounted(() => {
  /*  window.Echo.private(`project.${props.project.id}`)
     .listen('.comment.added', (e) => {
       props.project.tasks.forEach(task => {
         if (task.id === e.comment.task_id) {
           task.comments.push(e.comment); // live push
           alert('Comment added successfully');
         }
       });
     }); */

  window.Echo.channel(`project.${props.project.id}`)
    .listen('.comment.added', (e) => {
      props.project.tasks.forEach(task => {
        console.log([...task.comments]);  // First log
        if (task.id === e.comment.task_id) {
          task.comments.push({
            id: Math.floor(Math.random() * 100000000) + 1,
            body: 'This is a static comment',
            user: {
              name: 'John Doe'
            },
            created_at: new Date().toLocaleString(),
          }); // live push
          console.log([...task.comments]);  // Second log
          alert('Comment added successfully');
        }
      });
    });

});


console.log('Subscribing to: project.' + props.project.id);

window.Echo.connector.pusher.connection.bind('state_change', (states) => {
  console.log('Pusher connection state:', states.current);
});

Echo.connector.pusher.connection.bind('connected', () => {
  console.log('✅ Echo connected:', Echo.socketId());
});

Echo.connector.pusher.connection.bind('disconnected', () => {
  console.log('❌ Echo disconnected');
});

Echo.connector.pusher.connection.bind('message', (message) => {
  console.log('🛰️ Raw Pusher Message:', message);
});

</script>
