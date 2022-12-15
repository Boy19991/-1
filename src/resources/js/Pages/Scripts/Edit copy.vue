<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, Link, Head } from '@inertiajs/inertia-vue3'
import { onMounted, computed } from 'vue'
import { ref } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginFilePoster from 'filepond-plugin-file-poster';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import 'filepond/dist/filepond.min.css';



const props = defineProps({
    script: Object,
    path: String,
    errors: Object,
    csrf_token: String,
})
const form = useForm({
    id: props.script.id,
    title: props.script.title,
    outline: props.script.outline,
    thumbnail: props.script.thumbnail,
})

const original_thumbnail = props.path + props.script.thumbnail;
console.log(original_thumbnail)

onMounted(() => {
    FilePond.registerPlugin(FilePondPluginImagePreview);
    FilePond.registerPlugin(FilePondPluginFileValidateType);
    FilePond.registerPlugin(FilePondPluginFilePoster);
    const inputElement = document.querySelector('input[type="file"]');
    const pond = FilePond.create(inputElement, {
        server: {
            url: '/upload',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': props.csrf_token
            },
            name: 'filepond',
            //load: 'http://localhost/images/'
        },
        allowBrowse: true,
    });

    
    pond.files = [
        {
            // the server file reference
            source: "12345",

            // set type to local to indicate an already uploaded file
            options: {
                type: "local",

                // stub file information
                file: {
                    name: props.script.thumbnail,
                    size: 3500000,
                    type: "image/*",
                },
                allowBrowse: true,

                // pass poster property
                metadata: {
                    poster: "./" + props.script.thumbnail,
                },
            },
        },
    ];
    

    pond.on('processfile', (e) => {
        form.thumbnail = document.querySelector('input[name="filepond"]').value;
        console.log(form.thumbnail);
    });

    //display current image
    if (props.script.thumbnail){
        //pond.addFile(props.path + props.script.thumbnail)
    }
})



</script>

<template>
    <Head title="Upload PDF" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl text-gray-800 leading-tight">
               脚本詳細を編集
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <Link :href="route('scripts.index')" class="pl-4 pb-4">脚本一覧に戻る</Link>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4"> 
                    <div class="p-6 text-gray-900">

                            <form @submit.prevent="form.put(route('scripts.update'))">
                                <InputLabel for="title" value="タイトル" />
                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mb-8 mt-1 block w-300"
                                    v-model="form.title"
                                />


                                <InputLabel for="outline" value="あらすじ" />
                                <TextInput
                                    id="outline"
                                    type="text"
                                    class="mb-8 mt-1 block w-300"
                                    v-model="form.outline"
                                />
                  

                                <!--<InputLabel for="outline" value="画像" />
                                <img class="max-w-[200px]" :src="original_thumbnail">-->
                                <input 
                                type="file" 
                                name="filepond" 
                                id="filepond"
                                class="" />
                                
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
