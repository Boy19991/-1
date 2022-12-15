<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
    scripts: Object,
    laravelVersion: String,
    phpVersion: String,
});


</script>

<template>
    <Head title="Welcome" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        

        
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                Script Manager
            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="p-4">
                    <div
                    class=""  
                    v-for="script in scripts" :key="script.id">

                            <h3>{{script.title}}</h3>
                            <p>{{script.outline}}</p>
                            <img src="{{script.thumbnail}}" />

                    </div>    
                </div>
            </div>







            <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                <div class="text-center text-sm text-gray-500 sm:text-left">

                </div>

                <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </div>
            </div>
        </div>
    </div>
</template>
