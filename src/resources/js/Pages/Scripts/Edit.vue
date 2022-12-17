<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, Link, Head } from '@inertiajs/inertia-vue3'
import { onMounted, computed } from 'vue'
import { ref } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import NProgress from 'nprogress'


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
    image: props.script.image,
})

const current_image_path = ref(null)


const selectImage = (e) => {
    e.preventDefault();
    let data = new FormData()
    data.append('file', e.target.files[0])

    let xhr = new XMLHttpRequest();
    xhr.responseType = 'json';
    xhr.open('POST', '/upload');
    xhr.setRequestHeader('X-CSRF-TOKEN', props.csrf_token);
    
    xhr.upload.onprogress = function(event) {
        //console.log(`Uploaded ${event.loaded} of ${event.total} bytes`)
        //console.log(event.loaded)
        
        //NProgress.set(event.loaded / event.total * 100 | 0)
        NProgress.inc() 
    }
    xhr.onload = function() {
        //let responseObj = xhr.response;
        //alert(responseObj.message); // Hello, world!
        NProgress.done()
        console.log(xhr.response)
        form.image = xhr.response.image
        current_image_path.value = xhr.response.image_full_path
    }
    xhr.send(data)
    NProgress.start()

}
const message = computed(()=>{
    return props.result == 'error' ?
        '問題が発生しました' : '更新しました'
})
onMounted(() => {
    current_image_path.value = props.path + props.script.image

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

                            <form @submit.prevent="form.put(route('scripts.update', script.id))"
                            class="flex justify-between">
                                
                                
                                <div>
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

                                    <PrimaryButton style="padding:15px 20px;font-weight:normal; background-color:lightgray; 
                                                                        font-size:16px; color:black" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                        更新
                                    </PrimaryButton>
                                </div>

                                <div>


                                    <div>

                                        <img v-show="current_image_path" :src="current_image_path" class="mt-4" />
                                        <input 
                                            type="file" 
                                            @change="selectImage" 
                                            ref="photo" 
                                            id="file"
                                            class="custom-file-input" />
                                        <label for="file">クリック</label>
                                    </div>

                                    <div v-if="errors.image" class="font-bold text-red-600">
                                        {{ errors.image }}
                                    </div>

                                </div>

                                
                            </form>


                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>

    @import "scripts.css"
    
    </style>