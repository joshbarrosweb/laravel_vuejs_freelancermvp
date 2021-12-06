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
                Atualizar Projeto
            </template>

            <template #content>
                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="title" value="Titulo" />
                        <jet-input name="title" type="text" class="mt-1 block w-full" v-model="updateForm.title" autofocus />
                        <jet-input-error :message="updateForm.errors.title" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="skills" value="Especialidades" />
                        <jet-input name="skills" type="text" class="mt-1 block w-full" v-model="updateForm.skills" autofocus />
                        <jet-input-error :message="updateForm.errors.skills" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="details" value="Detalhes" />
                        <textarea id="details" type="text" class="mt-1 block h-32 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="updateForm.details" autofocus> </textarea>
                        <jet-input-error :message="updateForm.errors.details" class="mt-2" />
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
                Excluir Projeto
            </template>

            <template #content>
                Você tem certeza de que quer excluir esse projeto?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="destroying = false">
                    Abortar
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="destroy" :class="{ 'opacity-25': destroyForm.processing }" :disabled="destroyForm.processing">
                    Excluir Projeto
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
            'project',
        ],
        data() {
            return {
                updateForm: this.$inertia.form({
                    title: this.project.title,
                    details: this.project.details,
                    skills: this.project.skills,
                }),
                updating: false,
                destroyForm: this.$inertia.form(),
                destroying: false,
            }
        },
        methods: {
            update() {
                this.updateForm.put(route('company.projects.update', this.project), {
                    errorBag: 'projectUpdate',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.updating = false
                    }
                });
            },
            destroy() {
                this.destroyForm.delete(route('company.projects.destroy', this.project), {
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