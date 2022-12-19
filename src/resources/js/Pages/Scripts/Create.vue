<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, Link, Head } from '@inertiajs/inertia-vue3'
import { onMounted, computed } from 'vue'
import { ref } from 'vue'
import ScriptCreateEditForm from './ScriptCreateEditForm.vue'

const props = defineProps({
    path: String,
    errors: Object,
    csrf_token: String,
})
</script>

<template>
    <Head title="Add new script" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl text-gray-800 leading-tight">
                新規脚本
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        
                        
                        <ScriptCreateEditForm 
                            task="create"
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
