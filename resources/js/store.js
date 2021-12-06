import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

const api_url="http://localhost:8000/"

//vuex armazena os valores da negociação, projeto e bate-papo selecionado para que o sistema de negociação funcione corretamente!!!

export default new Vuex.Store({
    state: {
        user: {},
        negotiationId: null,
        projectId: null,
        chatId: null
    },
    mutations: {
        setUserState: (state, value) => state.user = value,
        setNegotiationId (state, payload) {
            state.negotiationId = payload
        },
        setProjectId (state, payload) {
            state.projectId = payload
        },
        setChatId (state, payload) {
            state.chatId = payload
        }
    },
    actions: {
        userStateAction: ({commit}) => {
            axios.get(`${api_url}api/user/me`).then(response => {
                const userResponse = response.data.user
                commit('setUserState', userResponse)
            })
        },
    },
    plugins: [createPersistedState()],
})
