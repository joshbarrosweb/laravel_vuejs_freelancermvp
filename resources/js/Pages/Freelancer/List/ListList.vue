<template>
    <div v-if="lists.total > 0">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nome do Projeto
                                    </th>
                                    <th v-if="user.role_id == 3" scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Empresa
                                    </th>
                                    <th v-if="user.role_id == 2" scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Candidato
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Data de Início
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="list in lists.data" :key="list.id">

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ list.title }}
                                        </td>

                                        <td v-if="user.role_id == 3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ list.name }}
                                        </td>

                                        <td v-if="user.role_id == 2" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ list.name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ list.status }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ list.created_at | formatDate }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <pagination :links="lists.links" />
            </div>
    </div>
</template>

<script>
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import Pagination from '@/Shared/Pagination'
    import store from '../../../store'

    export default {
        mounted(){
            console.log(this.lists);
        },
        data() {
            return {
                names: []
            }
        },
        computed: {
            user() {
                return store.state.user
            }
        },
        components: {
            JetActionSection,
            JetSectionBorder,
            Pagination,
        },
        props: [
            'lists',
        ],
    }
</script>
