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
                        <th>Trainingfile ID</th>
                        <th>Resultfile ID</th>
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
                            <td id="openaiID">{{fineTuneJobs.openai_id}}</td>
                            <td>{{fineTuneJobs.ai_model_id}}</td>
                            <td>
                                <span v-if="fineTuneJobs.ai_file_id">{{ fineTuneJobs.ai_file_id }}</span>
                                <span v-else>Filen er slettet</span>
                            </td>
                            <td class="link" @click="redirectToFineTuneJobs(fineTuneJobs.ai_model_result_file_id)">{{fineTuneJobs.ai_model_result_file_id}}</td>
                            <td>{{fineTuneJobs.type}}</td>
                            <td>{{fineTuneJobs.epochs}}</td>
                            <td>{{fineTuneJobs.batch_size}}</td>
                            <td id="longWord">{{fineTuneJobs.learning_rate_multiplier}}</td>
                            <td id="longWord">{{fineTuneJobs.prompt_loss_weight}}</td>
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
        this.getFineTuneJob();
    },
    methods: {
        getFineTuneJob() {
            axios.get('/fineTuneJob/get/' + this.id).then(res =>{
                this.fineTuneJobs = res.data
            });
        },
        redirectToFineTuneJobs(ai_model_result_file_id) {
            const url = route('models.seeModelResultFiles', {id: ai_model_result_file_id});
            this.$inertia.visit(url);
        },
    }
}
</script>