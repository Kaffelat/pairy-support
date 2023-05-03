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

        <form>
            <label>Training file</label>
            <input type="text" required v-model = "traningFile">

            <label>Validation file</label>
            <input type="text" v-model = "validationFile">

            <label>Type</label>
            <select v-model="type">
                <option value="davinci">Davinci</option>     
                <option value="curie">Curie</option>   
                <option value="babbage">Babbage</option>     
                <option value="ada">Ada</option>     
            </select>

            <label>Hvor mange gange skal modellen trænes?</label>
            <input type="text" v-model ='epochs' >

            <label>Hvad skal dens learningrate være?</label>
            <input type="text" v-model ='learningRate' >

            <label>Hvad skal den prompt loss være?</label>
            <input type="text" v-model ='promtLoss' >

            <div class="submit">
                <button>Create Model</button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

<script>
export default {
    data() {
        return {
            traningFile: '',
            validationFile:'',
            type:'curie',
            epochs:'',
            learningRate:'',
            promtLoss:''
        }
    }
}

</script>