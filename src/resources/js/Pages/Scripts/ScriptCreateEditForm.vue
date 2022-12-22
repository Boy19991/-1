<script setup>

import { useForm, Link, Head } from '@inertiajs/inertia-vue3'
import { onMounted, computed } from 'vue'
import { ref } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import NProgress from 'nprogress';


const props = defineProps({
    task: String,
    script: Object,
    errors: Object,
    csrf_token: String,
    path:String,
})

let form = useForm({
    id: props.script?.id || "",
    title: props.script?.title || "",
    broadcast_year: props.script?.broadcast_year || "",
    genre:props.script?.genre || "",
    continue:props.script?.continue || "",
    company:props.script?.company || "",
    script_writer:props.script?.script_writer || "",
    original_writer:props.script?.original_writer || "",
    original_name:props.script?.original_name || "",
    producer:props.script?.producer || "",
    performance:props.script?.performance || "",
    cast:props.script?.cast || "",
    outline:props.script?.outline || "",
    extra:props.script?.extra || "",
    owner:props.script?.owner || "",
    management_number:props.script?.management_number || "",
    keyword:props.script?.keyword || "",
    outline: props.script?.outline || "",
    image: props.script?.image || "",

    /*
    edit laravel side to avoid sending unneccessary data
    */
})

let feilds = {
    number: "番号",
    title: "タイトル",
    broadcast_year: "放送年",
    genre:"ジャンル",
    continue:"単発/連続",
    company:"放送系列/制作局",
    script_writer:"脚本家",
    original_writer:"原作者",
    original_name:"原作名",
    producer:"プロデューサー",
    performance:"演出",
    cast:"キャスト",
    outline:"作品概要",
    extra:"備考欄",
    owner:"脚本所蔵",
    management_number:"管理番号",
    keyword:"検索キーワード",

}

let isCreate = props.task == "create" ? true:false
let isEdit = props.task == "edit" ? true:false

const submit = () => {
    if (isCreate) form.post(route('scripts.store'))
    if (isEdit) form.put(route('scripts.update', props.script.id))
}

//thumbnail images
let current_image_path = ref(null)
onMounted(() => { 
    if (isEdit) current_image_path.value = props.path + props.script.image 
})

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

</script>
<template>
    
    <form @submit.prevent="submit"
    class="flex justify-between">
        
        
        <div>
            <!--
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
            -->

            <div v-for="value,key,index in form" :key="index">
            

                <template v-if="feilds[key]">
                    
                    <InputLabel for="" :value="feilds[key] + ' ' + value" />
                    <TextInput
                        id="outline"
                        type="text"
                        class="mb-8 mt-1 block w-300"
                        :value="value"
                        v-model="form[key]"
                    />
                </template>
                <template v-else>
                    
                </template>

            </div>

            <!--
                <BlogPost
                    v-for="post in posts"
                    :key="post.id"
                    :title="post.title"
                    />
            -->

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

</template>

<style>

@import "scripts.css"

</style>