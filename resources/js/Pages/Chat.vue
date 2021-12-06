<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chat
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex" style="min-height: 400px; max-height: 400px;">

                    <!-- list users -->

                    <div class="w-3/12 bg-gray-200 bg-opacity-25 border-r border-gray-200 overflow-y-scroll">
                        <ul>
                            <li
                                v-for="user in users" :key="user.id"
                                @click="() => {loadMessages(user.chat_id, user.id, user.project_id)}"
                                :class="(userActive && userActive.id == user.chat_id) ? 'bg-gray-200 bg-opacity-50' : ''"
                                class="p-6 text-lg text-gray-600 leading-7 font-semibold border-b border-gray-200 hover:bg-gray-200 hover:bg-opacity-50 hover:cursor-pointer">
                                <h1 class="font-bold text-medium flex items-center">
                                    {{ user.title }}
                                </h1>
                                <p class="flex text-sm items-center">
                                    {{ user.name }}
                                    <span v-if="user.notification" class="ml-2 w-2 h-2 bg-blue-500 rounded-full"></span>
                                </p>
                            </li>
                        </ul>
                    </div>

                    <!-- message box -->

                    <div class="w-9/12 flex flex-col justify-between">

                        <!-- message -->

                        <div class="w-full p-6 flex flex-col overflow-y-scroll">
                            <div
                                v-for="message in messages" :key="message.id"
                                :class="(message.from == $page.props.auth.user.id) ? 'text-right' : '' "
                                class="w-full mb-3 message">
                                <p
                                    :class="(message.from == $page.props.auth.user.id) ? 'messageFromMe' : 'messageToMe' "
                                    class="inline-block p-2 rounded-md" style="max-width: 75%;">
                                    {{ message.content }}
                                </p>
                                <span class="block mt-1 text-xs text-gray-500">{{ message.created_at | formatDate }}</span>
                            </div>
                        </div>

                          <!-- form -->

                            <div v-if="userActive" class="flex w-full bg-gray-200 bg-opacity-25 p-6 border-t border-gray-200">
                              <form class="w-full" v-on:submit.prevent="sendMessage">
                                 <div class="flex rounded-md overflow-hidden border border-gray-300">
                                     <input type="text" class="w-full flex-1 px-4 py-2 text-sm focus:outline-none" v-model="message_input">
                                    <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2">Enviar</button>
                                 </div>
                             </form>
                             <button v-if="$page.props.auth.user.role_id==2" @click="negotiate()" class="text-xs bg-red-500 hover:bg-green-500 text-white ml-2 px-4 py-2">Fechar Negociação</button>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import Vue from 'vue';
    import AppLayout from '@/Layouts/AppLayout'
    import store from '../store'

    export default {
        components: {
            AppLayout,
        },
        data() {
            return {
                users: [],
                messages: [],
                userActive: null,
                message_input: '',
                api_url: 'http://localhost:8000/'
            }
        },
        computed: {
            user() {
                return store.state.user
            },
            negotiationId() {
                return store.state.negotiationId
            },
            projectId() {
                return store.state.projectId
            },
            chatId() {
                return store.state.chatId
            }
        },

        methods: {
            async negotiate() {
                //cria a negociação
                const that = this

                await axios.post(`${this.api_url}api/negotiations/negotiate`, {
                    'negotiation_id': this.negotiationId,
                    'project_id': this.projectId
                }).then(response => {
                    if(response.status == 200) {
                        if(confirm(response.data.message)){
                            axios.post(`${that.api_url}api/negotiations/confirm`, {
                                'negotiation_id': that.negotiationId,
                                'project_id': that.projectId,
                                'freelancer_id': that.userActive.id,
                            }).then(response => {
                                //negociação bem-sucedida!
                                alert(response.data.message)
                            })
                        } else {
                            //negociação mal-sucedida!
                            //nenhuma lógica foi desenvolvida na sprint 1 sobre cancelar a confirmação de negociação...
                        }
                    } else {
                        //não é possivel negociar, pois o projeto já foi atribuido a outro freelancer...
                        alert(response.data.message)
                    }
                }).catch(function(error) {
                    //algo não-previsto aconteceu...
                    alert(error.response.data.message)
                })
            },

            scrollToBottom: function() {
                if(this.messages.length) {
                    //scroll até ultima mensagem do chat
                    document.querySelectorAll('.message:last-child')[0].scrollIntoView()
                }
            },

            loadMessages: async function(userId, negotiationId, projectId){
                //comunica ao vuex qual negociação foi selecionada e qual projeto a negociação pertence...

                store.commit('setNegotiationId', negotiationId);
                store.commit('setProjectId', projectId);
                store.commit('setChatId', userId);

                //carrega o informações sobre o usuario selecionado

                await axios.get(`${this.api_url}api/users/${userId}`).then(response => {
                    this.userActive = response.data.user
                })

                //carrega mensagens associadas ao usuario selecionado e a negociação

                await axios.post(`${this.api_url}api/messages/${userId}`, {
                            user_id: this.userActive.id,
                            project_id: this.projectId,
                            negotiation_id: this.negotiationId,
                        }).then(response => {

                        this.messages = response.data.messages
                    })

                // mostra o chat ativo (efeito hover)

                const user = this.users.filter((user) => {
                    if (user.chat_id === userId) {
                        return user
                    }
                })

                if (user) {
                    Vue.set(user[0], 'notification', false)
                }

                this.scrollToBottom()
            },

            //por alguma razão, a mensagem não envia apos ter adicionado 2 chaves estrangeiras no Model e Migration (message)...
            sendMessage: async function() {
                if(this.message_input == ''){
                    alert('Campo vazio!')
                } else {
                await axios.post(`${this.api_url}api/messages/store`, {
                    'content': this.message_input,
                    'to': this.userActive.id,
                    'project_id': this.projectId,
                    'negotiation_id': this.negotiationId,
                }).then(response => {
                    this.messages.push({
                        'from': this.chatId,
                        'to': this.userActive.id,
                        'content': this.message_input,
                        'project_id': this.projectId,
                        'negotiation_id': this.negotiationId,
                        'created_at': new Date().toISOString(),
                        'updated_at': new Date().toISOString(),
                    })

                    console.log(this.messages)

                    this.message_input = ''
                })

                this.scrollToBottom()
                }
            },
        },

        mounted() {
            //retorna os usuarios atraves da api laravel
            axios.get(`${this.api_url}api/users`).then(response => {
                this.users = Object.values(response.data.users)
                console.log(response.data.users)
            })

            //dispara o evento tempo-real das mensagens no laravel-websockets (precisa ligar o servidor em /laravel-websockets em desenvolvimento, ou ativar o supervisord em produção!)

            Echo.private(`user.${this.user.id}`).listen('.SendMessage', async (event) => {
                if(this.userActive && this.userActive.id === event.message.from) {
                    await this.messages.push(event.message)
                    this.scrollToBottom()
                } else {
                    const user = this.users.filter((user) => {
                        if (user.id === event.message.from) {
                            return user
                        }
                    })

                    if (user) {
                        Vue.set(user[0], 'notification', true)
                    }

                    //console.log('Notification is true')
                }

                //console.log(`Event: ${event}`)
            })
        }
    }
</script>

<style>

</style>
