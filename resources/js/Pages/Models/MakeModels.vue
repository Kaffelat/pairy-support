<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DropDownFile from '@/Components/DropDownFile.vue';
</script>

<template>
    <Head title="Make Models" />

    <AuthenticatedLayout>
        <template #header>
            <h2 id="headline" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Make models</h2>
        </template>

        <form id="formID" @submit.prevent="createModel">
            <div v-if="showAlert" class="alert" :class="alertClass">
                {{ alertMessage }}
            </div>
            <label>Type</label>
            <select v-model="type" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="curie">Curie</option> 
                <option value="davinci">Davinci</option>     
                <option value="babbage">Babbage</option>     
                <option value="ada">Ada</option>     
            </select>
            
            <drop-down-file></drop-down-file>
        </form>
    </AuthenticatedLayout>
</template>

<script>
export default {
    data() {
        return {
            traningFile: '',
            validationFile:null,
            type:'curie',
            epochs:'4',
            learningRate:'0.1',
            promtLoss:'0.01',
            
            showAlert: false,
            alertMessage: '',
            alertClass: '',
        }
    },
    methods: {
        createModel() {
            const data = {
                traningFile: this.traningFile,
                validationFile: this.validationFile,
                type: this.type,
                epochs: this.epochs,
                learningRate: this.learningRate,
                promtLoss: this.promtLoss
            };
            axios.post('/model/upload', data).then(res => {
                if (res.status === 200) {
                    this.showAlert = true;
                    this.alertMessage = 'Form submitted successfully.';
                    this.alertClass = 'success';
                }
                else {
                    this.showAlert = true;
                    this.alertMessage = 'Form submission failed.';
                    this.alertClass = 'error';
                }
            })
            .catch(error => {
                this.showAlert = true;
                this.alertMessage = "There was an error when you tried to create a new model. Please check that the id of the files you are trying to use is right and that you aren't using the same file for traning and validating";
                this.alertClass = 'error';
            });
        },
        
    }
}
</script>