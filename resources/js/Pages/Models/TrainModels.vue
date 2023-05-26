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
            <input type="text" v-model="modelName">

            <label>Training file</label>
            <input type="text" required v-model = "traningFile">

            <label>Validation file</label>
            <input type="text" v-model = "validationFile">

            <label>Hvor mange epochs skal modellen igennem?</label>
            <input type="text" v-model ='epochs' >

            <label>Hvad skal modellens learning rate multiplier være?</label>
            <input type="text" v-model ='learningRate' >

            <label>Hvad skal modellens prompt loss vægt være?</label>
            <input type="text" v-model ='promtLoss' >

            <div class="submit">
                <button type="submit" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Train Model</button>
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
            modelName:this.id,
            traningFile: '',
            validationFile:'',
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
                modelName: this.modelName,
                traningFile: this.traningFile,
                validationFile: this.validationFile,
                epochs: this.epochs,
                learningRate: this.learningRate,
                promtLoss: this.promtLoss
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
                console.error(error);

                this.showAlert = true;
                this.alertMessage = 'There was an error when you tried to train your model. Please check that the id of the file you are trying to use is right';
                this.alertClass = 'error';
        });
        }
    }
}
</script>