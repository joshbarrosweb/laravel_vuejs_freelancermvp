<template>
    <div>
        <button
            class="font-bold rounded-2xl px-4 py-2 cursor-pointer ml-6 text-sm bg-yellow-500 text-black focus:outline-none"
            @click="updating = true">
            Editar
        </button>

        <button class="font-bold rounded-2xl px-4 py-2 cursor-pointer ml-6 text-sm bg-red-500 text-white focus:outline-none"
                @click="destroying = true">
            Excluir
        </button>

        <jet-dialog-modal :show="updating" @close="updating = false">
            <template #title>
                Atualizar Usuário
            </template>

            <template #content>
                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="name" value="Nome" />
                        <jet-input name="name" type="text" class="mt-1 block w-full" v-model="updateForm.name" autofocus />
                        <jet-input-error :message="updateForm.errors.name" class="mt-2" />
                    </div>
                </div>
                <!-- <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="email" value="E-mail" />
                        <jet-input name="email" type="email" class="mt-1 block w-full" v-model="updateForm.email" autofocus />
                        <jet-input-error :message="updateForm.errors.email" class="mt-2" />
                    </div>
                </div> -->
                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="city" value="Cidade" />
                        <jet-input name="city" type="text" class="mt-1 block w-full" v-model="updateForm.city" autofocus />
                        <jet-input-error :message="updateForm.errors.city" class="mt-2" />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="formation" value="Formação" />
                        <jet-input name="formation" type="text" class="mt-1 block w-full" v-model="updateForm.formation" autofocus />
                        <jet-input-error :message="updateForm.errors.formation" class="mt-2" />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="linkedin" value="LinkedIn" />
                        <jet-input name="linkedin" type="text" class="mt-1 block w-full" v-model="updateForm.linkedin" autofocus />
                        <jet-input-error :message="updateForm.errors.linkedin" class="mt-2" />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="whatsapp" value="WhatsApp" />
                        <jet-input name="whatsapp" type="text" class="mt-1 block w-full" v-model="updateForm.whatsapp" autofocus />
                        <jet-input-error :message="updateForm.errors.whatsapp" class="mt-2" />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="skills" value="Especialidades" />
                        <jet-input name="skills" type="text" class="mt-1 block w-full" v-model="updateForm.skills" autofocus />
                        <jet-input-error :message="updateForm.errors.skills" class="mt-2" />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="username" value="Apelido" />
                        <jet-input name="username" type="text" class="mt-1 block w-full" v-model="updateForm.username" autofocus />
                        <jet-input-error :message="updateForm.errors.username" class="mt-2" />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="role_id" value="Hierarquia" />
                        <jet-input name="role_id" type="text" class="mt-1 block w-full" v-model="updateForm.role_id" autofocus />
                        <jet-input-error :message="updateForm.errors.role_id" class="mt-2" />
                    </div>
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click.native="updating = false">
                    Abortar
                </jet-secondary-button>

                <jet-button class="ml-2" @click.native="update" :class="{ 'opacity-25': updateForm.processing }" :disabled="updateForm.processing">
                    Salvar
                </jet-button>
            </template>
        </jet-dialog-modal>

        <jet-confirmation-modal :show="destroying" @close="destroying = false">
            <template #title>
                Excluir Usuário
            </template>

            <template #content>
                Você tem certeza de que quer excluir esse usuário?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="destroying = false">
                    Abortar
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="destroy" :class="{ 'opacity-25': destroyForm.processing }" :disabled="destroyForm.processing">
                    Excluir Usuário
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
            'user',
        ],
        data() {
            return {
                updateForm: this.$inertia.form({
                    name: this.user.name,
                    //email: this.user.email,
                    city: this.user.city,
                    formation: this.user.formation,
                    linkedin: this.user.linkedin,
                    whatsapp: this.user.whatsapp,
                    skills: this.user.skills,
                    username: this.user.username,
                    role_id: this.user.role_id,
                }),
                updating: false,
                destroyForm: this.$inertia.form(),
                destroying: false,
            }
        },
        methods: {
            update() {
                this.updateForm.put(route('admin.users.update', this.user), {
                    errorBag: 'userUpdate',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.updating = false
                    }
                });
            },
            destroy() {
                this.destroyForm.delete(route('admin.users.destroy', this.user), {
                    errorBag: 'default',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.destroying = false
                        this.destroyForm.reset()
                    }
                });
            },
        },
    }
</script>
