<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Projetos
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <project-new></project-new>
                <project-list :projects="projects"></project-list>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import ProjectNew from './ProjectNew'
    import ProjectList from './ProjectList'
    export default {
        props: [
            'projects',
        ],
        components: {
            AppLayout,
            JetSectionBorder,
            ProjectNew,
            ProjectList,
        },
    }
</script>