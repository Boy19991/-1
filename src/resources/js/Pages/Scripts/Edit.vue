<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, Link, Head } from '@inertiajs/inertia-vue3'
import { onMounted, computed } from 'vue'
import { ref } from 'vue'
import ScriptCreateEditForm from './ScriptCreateEditForm.vue'

const props = defineProps({
    script: Object,
    path: String,
    errors: Object,
    csrf_token: String,
})
</script>

<template>
    <Head title="Edit" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl text-gray-800 leading-tight">
               脚本を編集
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4"> 
                    <div class="p-6 text-gray-900">


                        <!-- did ben hong say I could pass an object here?
                            instead of all this silly shit?
                        -->
                        <ScriptCreateEditForm 
                            task="edit"
                            :script="props.script"
                            :errors="props.errors"
                            :path="props.path"
                            :csrf_token="props.csrf_token"
                        />


                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style>
@import "scripts.css"
</style>