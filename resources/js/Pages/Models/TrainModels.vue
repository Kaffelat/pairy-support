<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Train Models" />

    <AuthenticatedLayout>
        <template #header>
            <h2 id="headline" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Train model</h2>
        </template>

        <form id="formID" @submit.prevent="createModel">
            <div v-if="showAlert" class="alert" :class="alertClass">
                {{ alertMessage }}
            </div>

            <label>Model Name</label>
            <input type="text" v-model="type" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">

            <label>Training File</label>
            <select required v-model="traningFile" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option v-for="file in aiFiles" :value="file.openai_id" :key="file.openai_id">
                    {{ file.openai_id }} {{ selectedFile(file, traningFile) }}
                </option>
            </select>

            <label>Validation File</label>
            <select v-model="validationFile" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option v-for="file in aiFiles" :value="file.openai_id" :key="file.openai_id">
                    {{ file.openai_id }} {{ selectedFile(file, validationFile) }}
                </option>
            </select>

            <label >Hvor mange epochs skal modellen trænes?</label>
            <input type="number" v-model='epochs' class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">

            <label>Hvad skal modellens learning rate multiplier være?</label>
            <input type="text" v-model='learningRate' class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">

            <label>Hvad skal modellens prompt loss vægt være?</label>
            <input type="text" v-model='promptLoss' class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">

            <div class="submit">
                <button type="submit" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Create Model</button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

<script>
export default {
    props: {
        id: String
    },
    data() {
        return {
            aiFiles: [],

            type:this.id,
            traningFile: '',
            validationFile:'',
            epochs:4,
            learningRate:0.1,
            promptLoss:0.01,

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
        selectedFile(file, selectedValue) {
            return selectedValue === file.openai_id ? '' : 'Bytes: ' + file.byte_size;
        },
        createModel() {
            const data = {
                type: this.type,
                traningFile: this.traningFile,
                validationFile: this.validationFile,
                epochs: parseInt(this.epochs),
                learningRate: parseFloat(this.learningRate),
                promptLoss: parseFloat(this.promptLoss)
            };
            axios.post('/model/upload', data).then(res => {
                console.log(res.data);

                if (res.status === 200) {
                    this.showAlert = true;
                    this.alertMessage = 'Model is being trained.';
                    this.alertClass = 'success';
                }
                else {
                    this.showAlert = true;
                    this.alertMessage = 'Something failed.';
                    this.alertClass = 'error';
                }
            })
            .catch(error => {
                this.showAlert = true;
                this.alertMessage = 'There was an error when you tried to train your model. Please check that the id of the file you are trying to use is right';
                this.alertClass = 'error';
        });
        }
    }
}
</script>