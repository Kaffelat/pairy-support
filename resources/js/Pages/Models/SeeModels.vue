<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
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
                        <th>OpenAI ID</th>
                        <th>Owner ID</th>
                        <th>AIFile ID</th>
                        <th>Type</th>
                        <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody v-if="this.aiModels.length > 0">
                        <tr v-for="(aiModels) in this.aiModels">
                            <td>{{aiModels.id}}</td>
                            <td>{{aiModels.openai_id}}</td>
                            <td>{{aiModels.user_id}}</td>
                            <td>{{aiModels.ai_file_id ? aiModels.ai_file_id : 'Kunne ikke finde filen i databasen'}}</td>
                            <td>{{aiModels.type}}</td>
                            <td>
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="6">
                                Loading...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>

export default {
    name:'aiModels',
    data(){
        return {
            aiModels: []
        }
    },
    mounted() {
        this.getAIModels();
    },
    methods: {
        getAIModels() {
            axios.get('/test/model/download').then(res =>{
                this.aiModels = res.data
            });
        }
    }
}
</script>