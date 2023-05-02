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

<style>
    form {
        max-width: 420px;
        margin: auto;
        background: grey;
        text-align: left;
        padding: 20px;
        border-radius: 10px;
    }
    label {
        color: black;
        display: inline-block;
        margin-bottom: 10px;
        font-size: 1.0em;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: bold;
    }
    input {
        display: block;
        padding: 10px 6px;
        margin-bottom: 10px;
        width: 100%;
        box-sizing: border-box;
        border: none;
        border-bottom: 1px solid #ddd;
        color: #555;
    }

    button {
        background: white;
        display: inline-block;
        border: 0;
        padding: 10px 20px;
        margin-top: 20px;
        color: black;
        border-radius: 20px;
    }
    .submit {
        text-align: center;
    }
    .submit :hover {
        background-color: lightgrey;
        transition: 0.7s;
    }
</style>