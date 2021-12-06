<template>
    <div v-if="!rejected">
        <button
            class="font-bold rounded-2xl px-4 py-2 cursor-pointer ml-6 text-sm bg-blue-500 text-white focus:outline-none"
            @click="accepted = true">
            Aceitar
        </button>

        <!-- <button class="font-bold rounded-2xl px-4 py-2 cursor-pointer ml-6 text-sm bg-red-500 text-white focus:outline-none"
                @click="reject">
            Declinar
        </button> -->

        <jet-confirmation-modal :show="accepted" @close="accepted = false">
            <template #title>
                Aceitar Projeto
            </template>

            <template #content>
                Você tem certeza de que quer aceitar esse projeto?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="accept()">
                    Aceitar
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="accepted = false">
                    Agora Não
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>

    </div>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetConfirmationModal from "@/Jetstream/ConfirmationModal";
    import JetDangerButton from "@/Jetstream/DangerButton";
    import JetDialogModal from "@/Jetstream/DialogModal";
    import JetFormSection from "@/Jetstream/FormSection";
    import JetInput from "@/Jetstream/Input";
    import JetInputError from "@/Jetstream/InputError";
    import JetLabel from "@/Jetstream/Label";
    import JetSecondaryButton from "@/Jetstream/SecondaryButton";

    import store from '../../../store';
    export default {
        components: {
            JetButton,
            JetConfirmationModal,
            JetDangerButton,
            JetDialogModal,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },
        props: [
            'project',
        ],
        data() {
            return {
                api_url: "http://localhost:8000/",
                accepted: false,
                rejected: false,
            }
        },
        computed: {
            user() {
                return store.state.user
            }
        },
        methods: {
            async accept() {
                const that = this

                //console.log(`User ID: ${this.user.id}`)
                //console.log(`Company ID: ${this.project.company_id}`)
                //console.log(`Project ID: ${this.project.id}`)

                await axios.post(`${this.api_url}api/negotiations/store`, {
                    'freelancer_id': this.user.id,
                    'company_id': this.project.company_id,
                    'project_id': this.project.id
                }).then(response => {
                    alert(response.data.message)
                    that.accepted = false
                    //console.log(response.data.message)
                }).catch(function(error) {
                    alert(error.response.data.message)
                    that.accepted = false
                    //console.log(error.response.data.message)
                })
            },

            reject() {
                console.log('rejeitado')
                //this.$emit('reject', 'true')
            }
        },
    }
</script>
