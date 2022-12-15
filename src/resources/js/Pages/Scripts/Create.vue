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


const props = defineProps({
    path: String,
    errors: Object,
    csrf_token: String

})
const form = useForm({
    title: null,
    outline: null,
    image_filename: null,
 
});


//this didnt work with v-show="current_image_path" why.... .value!
let current_image_path = ref(null)

const selectImage = (e) => {
    e.preventDefault();
    let data = new FormData()
    data.append('file', e.target.files[0])
    fetch('/upload', {
        method: 'POST',
        body: data,
        headers: {
            'X-CSRF-TOKEN': props.csrf_token
            //'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data)
        form.image_filename = data.image_filename
        current_image_path.value = data.image_full_path
    }).catch(error => {console.error(error)})

}
const message = computed(()=>{
    return props.result == 'error' ?
        '問題が発生しました' : '更新しました'
})
onMounted(() => {


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
                        
                            <form @submit.prevent="form.post(route('scripts.store'))"
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
