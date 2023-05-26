<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
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

            <label>Training File</label>
            <input type="text" required v-model = "traningFile">

            <label>Validation File</label>
            <input type="text" v-model = "validationFile">

            <label>Type</label>
            <select v-model="type" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="curie">Curie</option> 
                <option value="davinci">Davinci</option>     
                <option value="babbage">Babbage</option>     
                <option value="ada">Ada</option>     
            </select>

            <label>Hvor mange epochs skal modellen trænes?</label>
            <input type="text" v-model ='epochs' >

            <label>Hvad skal modellens learning rate multiplier være?</label>
            <input type="text" v-model ='learningRate' >

            <label>Hvad skal modellens prompt loss vægt være?</label>
            <input type="text" v-model ='promtLoss' >

            <div class="submit">
                <button type="submit" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Create Model</button>
            </div>

        </form>
    </AuthenticatedLayout>
</template>

<script>
export default {
    data() {
        return {
            traningFile: 'file-LkOO9ZnmMHlp7SMfPqQO7TC2',
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
                console.error(error);

                this.showAlert = true;
                this.alertMessage = 'There was an error when you tried to create a new model. Please check that the id of the files you are trying to use is right';
                this.alertClass = 'error';
        });
        }
    }

}

</script>