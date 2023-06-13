<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="See Result File" />

    <AuthenticatedLayout>
        <template #header>
            <h2 id="headline" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Result File</h2>  
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-200">
                <table id="firstTable">
                    <thead>
                        <tr>
                        <th>Step</th>
                        <th>Tokens Seen</th>
                        <th>Eksemples Seen</th>
                        <th>Training Loss</th>
                        <th>Training Accuracy</th>
                        <th>Training Token Accuracy</th>
                        </tr>
                    </thead>
                    <tbody v-if="this.resultFile.length > 0">
                        <tr v-for="(resultFile) in this.resultFile">
                            <td id="step">{{resultFile[0]}}</td>
                            <td id="tokens seen">{{resultFile[1]}}</td>
                            <td id="eksemples seen">{{resultFile[2]}}</td>
                            <td id="traning loss">{{resultFile[3]}}</td>
                            <td id="traning accuracy">{{resultFile[4]}}</td>
                            <td id="traning token accuracy">{{resultFile[5]}}</td>
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
    props: {
        id: String
    },
    data() {
        return {
            resultFile: []
        }
    },
    mounted() {
        this.getResultFile();
    },
    methods: {
        getResultFile() {
            axios.get('/resultFile/get/' + this.id).then(res =>{
                this.resultFile = res.data
            });
        },
    }
}
</script>