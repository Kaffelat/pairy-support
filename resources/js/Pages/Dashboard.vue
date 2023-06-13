<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 id="headline" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex items-center justify-center p-6 text-gray-900 dark:text-gray-100">
                        Velkommen til Pairy's oversigt over OpenAI!
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        Her vil du kunne finde informationer over hvilke modeller du har adgang til hos OpenAI, hvordan deres træning er gået og hvilken fil der er blevet brugt til træningen, 
                        hvilket filer du har adgang til når du skal træne og validere samt mulighed for at lave nye modeller og uploade ny træningsdata.
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        Vigtige ord at have styr på hvad de betyder:
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <span class="font-bold">Epochs:</span> 
                        En Epoch er hvor mange gange din model skal trænes med det træningssæt du har givet det, så hvis den står på 4 og du har 10 prompts i dit træningssæt så ser dit sæt 40 prompts.
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <span class="font-bold">Batch size:</span> 
                        Batch size er hvor mange filer du bruger når du træner din model.                            
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <span class="font-bold">Learning Rate Multiplier:</span> 
                        Learning rate er ens betydigt med hvor meget en model ændre på dens parameter når vi træner den. Bruges der et stort datasæt skal den sættes højt ellers hold det småt.
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <span class="font-bold">Prompt Loss Weight:</span> 
                        Prompt loss weight påvirker modellens output. Jo højere den er jo mere vil modellens svar ligge sig op af den promt den har fået. Jo lavere jo mere frihed vil modellen have til at svare.                            
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <span class="font-bold">Training Loss:</span>
                        Training loss er hvor meget modellen afviger fra det ønskede svar. Jo højere en training loss jo mere afviger svaret.
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <span class="font-bold">Training Accuracy:</span>  
                        Training Accuracy er om modellen har ramt rigtigt eller ej. Hvis Training Accuracy er 0 er svaret modellen kom frem til på en prompt ikke 100% lig med det svar der stod i completionen. hvis den har ramt 100% er den 1
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <span class="font-bold">Training Token Accuracy:</span> 
                        Training Token Accuracy er hvor mange tokens modellen har ramt ramt rigtigt når den svare. 
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
