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
            <div id="modelDeletion" v-if="showAlert" class="alert" :class="alertClass">
            {{ alertMessage }}
            </div>
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
                            <td id="openaiID" class="link" @click="redirectToFineTuneJobs(aiModels.openai_id)">{{aiModels.openai_id}}</td>
                            <td>{{aiModels.user_id}}</td>
                            <td>{{aiModels.type}}</td>
                            <td>
                                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 border border-green-700 rounded" @click="trainModel(aiModels.openai_id)">
                                    Train
                                </button>
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
            aiModels: [],
            showAlert: false,
            alertMessage: '',
            alertClass: '',
        }
    },
    mounted() {
        this.getModels();
        this.getModelResultFiles();
        this.getFineTuneJobs();
    },
    methods: {
        getModels() {
            axios.get('/model/download').then(res =>{
                this.aiModels = res.data
            });
        },
        getModelResultFiles() {
            axios.get('/resultFile/download')
        },
        getFineTuneJobs() {
            axios.get('/fineTuneJob/download')
        },
        deleteModels(openai_id) {
            axios.delete('/model/delete/' + openai_id).then(res => {
                this.getModels();
                
                if (res.status === 200) {
                    this.showAlert = true;
                    this.alertMessage = 'Model deleted successfully.';
                    this.alertClass = 'success';
                }
                else {
                    this.showAlert = true;
                    this.alertMessage = 'Model failed deletion';
                    this.alertClass = 'error';
                }
            })
            .catch(error => {
                console.error(error);
                this.showAlert = true;
                this.alertMessage = "There was an error when you tried to delete this model " + openai_id;
                this.alertClass = 'error';
            })
        },
        redirectToFineTuneJobs(openai_id) {
            const url = route('models.seeFineTuneJobs', {id: openai_id});
            this.$inertia.visit(url);
        },
        trainModel(openai_id) {
            const url = route('models.trainModels', {id: openai_id});
            this.$inertia.visit(url);
        }
    }
}
</script>
