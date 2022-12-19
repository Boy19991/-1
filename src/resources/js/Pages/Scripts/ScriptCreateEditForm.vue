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

let form = {}
if (props.task == "create"){
    form = useForm({
        title: "",
        outline: "",
        image: "",
    })

} else if (props.task == "edit"){
    form = useForm({
        id: props.script.id,
        title: props.script.title,
        outline: props.script.outline,
        image: props.script.image,
    })
}


const submit = () => {
    if (props.task == "create") {
        form.post(route('scripts.store'))
    }
    else if (props.task == "edit"){
       form.put(route('scripts.update', props.script.id))
    }
}

//thumbnail images
let current_image_path = ref(null)
onMounted(() => { 
    if (props.task == "edit") current_image_path.value = props.path + props.script.image 
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

</template>

<style>

@import "scripts.css"

</style>