<template>
    <label>Training File</label>
    <select v-model="traningFile" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
    <input type="text" v-model='epochs' class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">

    <label>Hvad skal modellens learning rate multiplier være?</label>
    <input type="text" v-model='learningRate' class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">

    <label>Hvad skal modellens prompt loss vægt være?</label>
    <input type="text" v-model='promtLoss' class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500">

    <div class="submit">
        <button type="submit" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Create Model</button>
    </div>

</template>

<script>
export default {
    data() {
        return {
            aiFiles: [],
            traningFile: '', 
            validationFile: '', 
        };
    },
    mounted () {
        this.getFiles();
    },
    methods: {
        selectedFile(file, selectedValue) {
            return selectedValue === file.openai_id ? '' : 'Bytes: ' + file.byte_size;
        },
        getFiles() {
                axios.get('/file/download').then(res =>{
                    this.aiFiles = res.data
                });
            },
        }
    };
</script>