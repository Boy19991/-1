<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, Link, Head } from '@inertiajs/inertia-vue3'
import { onMounted, computed } from 'vue'
import { ref } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';


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

const current_image_path = computed(()=>{
    
})

const image_form = useForm({
    image: null,
})

const selectImage = (e) => {
    e.preventDefault();
    image_form.image = e.target.files[0];
    form.thumbnail_url = URL.createObjectURL(image_form.image);
    const result = image_form.post('/upload', {
        preserveScroll: true,
        onSuccess: (response) => {
            console.log('response is: ' + response)
        }
    })
    console.log(result)
}

onMounted(() => {

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
                  
                                <!-- @input="form.image = $event.target.files[0]" -->
                                <input type="file" 
                                
                                @change="selectImage" 
                                
                                ref="photo" 
                                class="w-full
                                        px-4
                                        py-2
                                        mt-2
                                        border
                                        rounded-md
                                        focus:outline-none
                                        focus:ring-1
                                        focus:ring-blue-600
                                        mb-5
                                    " />
                                <img v-if="url" :src="url" class="w-full mt-4 h-80" />
                                <div v-if="errors.image" class="font-bold text-red-600">
                                    {{ errors.image }}
                                </div>
                                






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
