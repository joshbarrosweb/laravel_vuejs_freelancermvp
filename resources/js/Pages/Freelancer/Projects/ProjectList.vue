<template>
    <div v-if="projects.total > 0">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Titulo
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Descrição
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Especialidades
                                    </th>
                                    <th scope="col" width="200" class="px-6 py-3 bg-gray-50">

                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="project in projects.data" :key="project.id">

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ getProjectTitle(project) }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ getProjectDetails(project) }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ getProjectSkills(project) }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <project-item :project="project"/>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>    
                <pagination :links="projects.links" />
            </div>
    </div>
</template>

<script>
    import ProjectItem from './ProjectItem'
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import Pagination from '@/Shared/Pagination'
    export default {
        components: {
            ProjectItem,
            JetActionSection,
            JetSectionBorder,
            Pagination,
        },
        methods: {
            getProjectTitle(project) {
                let title = this.stripTags(project.title);

                return title.length > 30 ? title.substring(0, 30) + '...' : title;
            },

            getProjectDetails(project) {
                let details = this.stripTags(project.details);

                return details.length > 50 ? details.substring(0, 50) + '...' : details;
            },

            getProjectSkills(project) {
                let skills = this.stripTags(project.skills);

                return skills.length > 20 ? skills.substring(0, 20) + '...' : skills;
            },

            stripTags(text) {
            return text.replace(/(<([^>]+)>)/ig, '');
            }
        },
        props: [
            'projects',
        ],
    }
</script>