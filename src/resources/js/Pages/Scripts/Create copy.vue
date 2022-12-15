<script setup>
import { onMounted, computed } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { useForm } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import * as FilePond from 'filepond';
import 'filepond/dist/filepond.min.css';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';


const props = defineProps({
    //result: String,
    errors: Object,
    csrf_token: String

})
const form = useForm({
    title: null,
    outline: null,
    thumbnail: null,
});

const message = computed(()=>{
    return props.result == 'error' ?
        '問題が発生しました' : '更新しました'
})

onMounted(() => {
    FilePond.registerPlugin(FilePondPluginImagePreview);
    FilePond.registerPlugin(FilePondPluginFileValidateType);
    const inputElement = document.querySelector('input[type="file"]');
    const pond = FilePond.create(inputElement, {
        server: {
            url: '/upload',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': props.csrf_token
            },
            name:'filepond',
        }
    });
    pond.on('processfile', (e) => {
        form.thumbnail = document.querySelector('input[name="filepond"]').value;
        console.log(form.thumbnail);
    });

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
                        
                            <form @submit.prevent="form.post(route('scripts.store'))">

                                <InputLabel for="title" value="タイトル" />
                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mb-8 mt-1 block w-300"
                                    v-model="form.title"
                                />
                                <div v-if="errors.title">
                                </div>

                                <InputLabel for="outline" value="あらすじ" />
                                <TextInput
                                    id="outline"
                                    type="text"
                                    class="mb-8 mt-1 block w-300"
                                    v-model="form.outline"
                                />
                                <InputLabel for="outline" value="画像" />


                                <input 
                                type="file" 
                                name="filepond" 
                                id="filepond"
                                />


                                <PrimaryButton 
                                    style="padding:15px 20px;font-weight:normal; background-color:lightgray; 
                                    font-size:16px; color:black"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                        更新
                                </PrimaryButton>
                                
                            </form>
                        


                        

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
