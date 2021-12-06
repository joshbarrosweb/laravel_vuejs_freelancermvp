<template>
    <div v-if="users.total > 0">
        <jet-section-border />
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nome
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cidade
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Formação
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        LinkedIn
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        WhatsApp
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Especialidades
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Apelido
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Hierarquia
                                    </th>
                                    <th scope="col" width="200" class="px-6 py-3 bg-gray-50">

                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="user in users.data" :key="user.id">

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ getUserNome(user) }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ getUserEmail(user) }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ user.city }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ user.formation }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ user.linkedin }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ user.whatsapp }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ user.skills }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ user.username }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ user.role_id }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <user-item :user="user"/>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <pagination :links="users.links" />
            </div>
    </div>
</template>

<script>
    import UserItem from './UserItem'
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import Pagination from '@/Shared/Pagination'
    export default {
        components: {
            UserItem,
            JetActionSection,
            JetSectionBorder,
            Pagination,
        },
        methods: {
            getUserNome(user) {
                let name = user.name //this.stripTags(user.name);

                return name.length > 30 ? name.substring(0, 30) + '...' : name;
            },

            getUserEmail(user) {
                let email = user.email //this.stripTags(user.email);

                return email.length > 30 ? email.substring(0, 30) + '...' : email;
            },

            getUserCidade(user) {
                let city = user.city //this.stripTags(user.city);

                return city.length > 30 ? city.substring(0, 30) + '...' : city;
            },

            getUserFormacao(user) {
                let formation = user.formation //this.stripTags(user.formation);

                return formation.length > 30 ? formation.substring(0, 30) + '...' : formation;
            },

            getUserLinkedin(user) {
                let linkedin = user.linkedin //this.stripTags(user.linkedin);

                return linkedin.length > 30 ? linkedin.substring(0, 30) + '...' : linkedin;
            },

            getUserWhatsapp(user) {
                let whatsapp = user.whatsapp //this.stripTags(user.whatsapp);

                return whatsapp.length > 30 ? whatsapp.substring(0, 30) + '...' : whatsapp;
            },

            getUserEspecialidades(user) {
                let skills = user.skills //this.stripTags(user.skills);

                return skills.length > 30 ? skills.substring(0, 30) + '...' : skills;
            },

            /*getUserApelido(user) {
                let username = user.username //this.stripTags(user.username);

                return username.length > 30 ? username.substring(0, 30) + '...' : username;
            },/*

            /*getUserRole(user) {
                let role_id = user.role_id //this.stripTags(user.role_id);

                return role_id.length > 30 ? role_id.substring(0, 30) + '...' : role_id;
            },*/

            /*stripTags(text) {
                return text.replace(/(<([^>]+)>)/ig, '');
            }*/
        },
        props: [
            'users',
        ],
    }
</script>
