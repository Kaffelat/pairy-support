<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
</script>

<template>
    <Head title="See Traning Files" />

    <AuthenticatedLayout>
        <template #header>
            <h2 id="headline" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">See traningdata</h2>
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
                        <th>Name</th>
                        <th>Bytes in File</th>
                        <th>File Purpose</th>
                        <th></th>
                        </tr>
                    </thead>
                    <tbody v-if="this.aiFiles.length > 0">
                        <tr v-for="(aiFiles) in this.aiFiles">
                            <td>{{aiFiles.id}}</td>
                            <td id="openaiID">{{aiFiles.openai_id}}</td>
                            <td>{{aiFiles.user_id}}</td>
                            <td>{{aiFiles.name}}</td>
                            <td>{{aiFiles.byte_size}}</td>
                            <td>{{aiFiles.file_purpose}}</td>
                            <td>
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded" @click="deleteFile(aiFiles.openai_id)">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="7">
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
    name:'aiFiles',
    data(){
        return {
            aiFiles: [],
            showAlert: false,
            alertMessage: '',
            alertClass: '',
        }
    },
    mounted() {
        this.getFiles();
    },
    methods: {
        getFiles() {
            axios.get('/file/download').then(res =>{
                this.aiFiles = res.data
            });
        },
        deleteFile(openai_id) {
            axios.delete('/file/delete/' + openai_id).then(res => {
                this.getFiles();

                if (res.status === 200) {
                    this.showAlert = true;
                    this.alertMessage = 'File deleted successfully.';
                    this.alertClass = 'success';
                }
                else {
                    this.showAlert = true;
                    this.alertMessage = 'File failed deletion';
                    this.alertClass = 'error';
                }
            })
            .catch(error => {
                console.error(error);
                this.showAlert = true;
                this.alertMessage = "There was an error when you tried to delete this File: " + openai_id;
                this.alertClass = 'error';
            })
        }
    }
}
</script>