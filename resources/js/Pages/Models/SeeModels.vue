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
                        <th>Type</th>
                        <th></th>
                        </tr>
                    </thead>
                    <tbody v-if="this.aiModels.length > 0">
                        <tr v-for="(aiModels) in this.aiModels">
                            <td>{{aiModels.id}}</td>
                            <td id="td" class="openai-link" @click="redirectToModel(aiModels.openai_id)">{{aiModels.openai_id}}</td>
                            <td>{{aiModels.user_id}}</td>
                            <td>{{aiModels.type}}</td>
                            <td>
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded" @click="deleteModels(aiModels.openai_id)">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="5">
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
    data(){
        return {
            aiModels: []
        }
    },
    mounted() {
        this.getModels();
        this.getFineTuneJobs();
    },
    methods: {
        getModels() {
            axios.get('/model/download').then(res =>{
                this.aiModels = res.data
            });
        },
        getFineTuneJobs() {
            axios.get('/fineTuneJob/download')
        },
        deleteModels(openai_id) {
            console.log(openai_id)
            
            axios.delete('/model/delete/' + openai_id).then(res => {
                this.getModels();
            });
        },
        redirectToModel(openai_id) {
            console.log(openai_id);
            this.$inertia.visit('/models/seeFineTuneJobs/' + openai_id);
        },
    }
}
</script>
