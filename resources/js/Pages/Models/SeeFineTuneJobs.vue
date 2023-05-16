<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>
    <Head title="See Models" />

    <AuthenticatedLayout>
        <template #header>
            <h2 id="headline" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Fine Tune Jobs</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-200">
                <table id="firstTable">
                    <thead>
                        <tr>
                        <th>Id</th>
                        <th>OpenAI ID</th>
                        <th>Model ID</th>
                        <th>File ID</th>
                        <th>Result File ID</th>
                        <th>Type</th>
                        <th>Epochs</th>
                        <th>Batch Size</th>
                        <th>Learning Rate Multiplier</th>
                        <th>Promt Loss Weight</th>
                        </tr>
                    </thead>
                    <tbody v-if="this.fineTuneJobs.length > 0">
                        <tr v-for="(fineTuneJobs) in this.fineTuneJobs">
                            <td>{{fineTuneJobs.id}}</td>
                            <td>{{fineTuneJobs.openai_id}}</td>
                            <td>{{fineTuneJobs.ai_model_id}}</td>
                            <td>{{fineTuneJobs.ai_file_id}}</td>
                            <td>{{fineTuneJobs.ai_model_result_id}}</td>
                            <td>{{fineTuneJobs.type}}</td>
                            <td>{{fineTuneJobs.epochs}}</td>
                            <td>{{fineTuneJobs.batch_size}}</td>
                            <td>{{fineTuneJobs.learning_rate_multiplier}}</td>
                            <td>{{fineTuneJobs.prompt_loss_weight}}</td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="10">
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
    props: {
        id: String
    },
    data() {
        return {
            fineTuneJobs: []
        }
    },
    mounted() {
        this.getFineTuneJobs();
    },
    methods: {
        getFineTuneJobs() {
            axios.get('/fineTuneJob/get/' + this.id).then(res =>{
                this.fineTuneJobs = res.data
            });
        },
    }
}
</script>