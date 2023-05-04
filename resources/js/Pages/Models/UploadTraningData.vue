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
            <form @submit.prevent="submitForm">
                <div>
                    <label for="file">Select a file:</label>
                    <input type="file" name="file" ref="fileInput" @change="handleFileChange">
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>

    </AuthenticatedLayout>
</template>

<script>

export default {
    data() {
    return {
      selectedFile: null,
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

      axios.post('/test/upload', formData)
        .then(res => {
            this.$refs.fileInput.value = '';

            console.log(this.selectedFile);
            
            console.log('File uploaded successfully!');
        })
    },
  }
}
</script>