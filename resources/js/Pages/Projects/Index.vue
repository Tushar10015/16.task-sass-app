<template>
    <AppLayout title="Projects">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Projects
            </h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

                <Link href="/projects/create"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none transition ease-in-out duration-150">
                + New Project
                </Link>

                <div class="bg-white shadow-sm rounded-lg divide-y">
                    <div v-for="project in projects" :key="project.id" class="p-4">
                        <Link :href="`/projects/${project.id}`"
                            class="text-lg font-medium text-indigo-700 hover:underline">
                        {{ project.name }}
                        </Link>
                        <p class="text-gray-600 text-sm mt-1">{{ project.description }}</p>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({ projects: Array });
</script>
