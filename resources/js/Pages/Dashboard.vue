<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 id="headline" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">Velkommen til Pandiwebs oversigt over OpenAI!</div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">Her vil du kunne finde informationer over hvilke modeller der ligger hos OpenAI, 
                        hvilken træningsdata der er samt mulighed for at lave nye modeller og uploade ny træningsdata.</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
