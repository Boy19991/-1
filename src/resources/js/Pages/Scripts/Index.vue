<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import NavLink from '@/Components/NavLink.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, reactive, computed } from 'vue';

const props = defineProps({
    result: String,
    scripts:Object,
    path:String,
})

let display_image = computed(()=>{

})

</script>

<template>
    <Head title="Scripts Index" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl text-gray-800 leading-tight">脚本一覧</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <Link
                    :href="route('scripts.create')"
                    class="text-lg bg-blue-600 text-zinc-200 p-3 rounded-md inline-block mb-4">
                    脚本を追加
                </Link>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    


                    <div 
                    class="t-grid p-4 gap-4 flex"
                    v-for="script in scripts" 
                    :key="script.id">

                        <div class="flex gap-4">
                            <img id="thumbnail" :src="script.image" v-if="script.image !==''">
                            <div v-else>
                                <div id="no_image"></div>
                            </div>
                            <div class="text-3xl pt-2">{{script.title}}</div>
                        </div>
                        <div class="">
                            <Link :href="route('scripts.edit', script.id)"  as="button" class=" bg-green-300 rounded-md p-4 mr-2">編集</Link>
                            <Link :href="route('scripts.destroy', script.id)" method="delete" as="button" class=" bg-red-900 text-cyan-50 rounded-md p-4 mr-2">削除</Link>
                        </div>

                    </div>    

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

    #thumbnail {
        max-width:100px;

    }
    .t-grid {
        /*
        display:grid;
        grid-template-columns:repeat(5,1fr);
        */

        display: flex;
        justify-content: space-between;
    }
    /*
    #t-flex {
        display:flex;
    }
    */
    #no_image {
        height:50px;
        width:50px;
        background-color: lightslategrey;
    }

</style>