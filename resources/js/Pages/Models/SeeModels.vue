<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="See Models" />

    <AuthenticatedLayout>
        <template #header>
            <h2 id="headline" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Models</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-200">
                <table id="firstTable">
                    <thead>
                        <tr>
                        <th>Id</th>
                        <th>OpenAI id</th>
                        <th>Creater</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in rows">
                        <td>{{row.id}}</td>
                        <td>{{row.openAIId}}</td>
                        <td>{{row.userWhoUploaded}}</td>
                        <td>{{row.type}}</td>
                        <td>{{row.name}}</td>
                        <td>{{row.createdAt}}</td>
                        <td>{{row.updatedAt}}</td>
                        </tr>
                    </tbody>
                    </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

