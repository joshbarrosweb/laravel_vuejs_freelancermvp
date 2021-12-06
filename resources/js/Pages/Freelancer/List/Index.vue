<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Meus Projetos
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <list-list :lists="lists"></list-list>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import ListList from './ListList'
    export default {
        props: [
            'lists',
        ],
        components: {
            AppLayout,
            JetSectionBorder,
            ListList,
        },
    }
</script>
