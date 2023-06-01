<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Upload Traning Data" />

    <AuthenticatedLayout>
        <template #header>
            <h2 id="headline" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Upload traningdata</h2>
        </template>
        
        <div>
            <form id="formID" @submit.prevent="submitForm">
                <div v-if="showAlert" class="alert" :class="alertClass">
                    {{ alertMessage }}
                </div>
                
                <div class ="flex flex-col items-center">
                    <label class="mb-2 inline-block text-neutral-700 dark:text-neutral-200"  for="file_input">Select A File</label>
                    <input class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary" ref="fileInput" type="file" @change="handleFileChange">
                </div>
                
                <div class="submit" >
                    <button type="submit" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Upload File</button>
                </div>
            </form>
        </div>

    </AuthenticatedLayout>
</template>

<script>

export default {
    data() {
    return {
        selectedFile: null,
        showAlert: false,
        alertMessage: '',
        alertClass: '',
    };
  },
  methods: {
    handleFileChange(event) {
        const file = event.target.files[0];
   
        if (file && file.name.endsWith('.jsonl')) {
            this.selectedFile = file;
        }
        else {
            this.selectedFile = null;

            this.$refs.fileInput.value = '';

            alert('Please select a JSONL file.');
        }
    },
    submitForm() {
        const formData = new FormData();

        formData.append('file', this.selectedFile);

        axios.post('/file/upload', formData)
            .then(res => {
                this.selectedFile = null;
                this.$refs.fileInput.value = '';
            
                if (res.status === 200) {
                    this.showAlert = true;
                    this.alertMessage = 'File uploaded successfully.';
                    this.alertClass = 'success';
                }
                else {
                    this.showAlert = true;
                    this.alertMessage = 'File upload failed.';
                    this.alertClass = 'error';
                }
            })
            .catch(error => {
                this.showAlert = true;
                this.alertMessage = 'There was an error when you tried to upload a new file. Please check that file is not too big in size';
                this.alertClass = 'error';
            });
        }
    },
}
</script>