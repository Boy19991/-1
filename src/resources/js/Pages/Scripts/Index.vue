<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import NavLink from '@/Components/NavLink.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    result: String,
    scripts:Object,
    path:String,
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
                    
                    {{result}}
                    <div 
                    id="t-grid"
                    class="p-4 gap-4 flex"
                    v-for="script in scripts" :key="script.id">

                        <img id="thumbnail" :src="path + script.image">
                        <span class="">{{script.title}}</span>
                        <!--<div class="">{{script.outline}}</div>-->
                        
                        <div class="">
                            <Link :href="route('scripts.edit', script.id)"  as="button"
                            class=" bg-green-300 rounded-md p-4 mr-2">編集</Link>
                            <Link :href="route('scripts.destroy', script.id)" method="delete" as="button"
                            class=" bg-red-900 text-cyan-50 rounded-md p-4 mr-2">削除</Link>
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
    #t-grid {
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

</style>