<template>
    <jet-form-section @submitted="store">
        <template #title>
            Criar Projeto
        </template>

        <template #description>
            Criar um novo Projeto.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="title" value="Titulo" />
                <jet-input id="title" type="text" class="mt-1 block w-full" v-model="form.title" autofocus />
                <jet-input-error :message="form.errors.title" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="skills" value="Especializações" />
                <jet-input id="skills" type="text" class="mt-1 block w-full" v-model="form.skills" autofocus />
                <jet-input-error :message="form.errors.skills" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="details" value="Detalhes" />
                <textarea id="details" type="text" class="mt-1 block h-32 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.details" autofocus> </textarea>
                <jet-input-error :message="form.errors.details" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Projeto criado.
            </jet-action-message>
            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Salvar
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },
    data() {
        return {
            form: this.$inertia.form({
                title: '',
                details: '',
                skills: '',
            })
        }
    },
    methods: {
        store() {
            this.form.post(route('company.projects.store'), {
                errorBag: 'projectStore',
                preserveScroll: true,
                onSuccess: () => {
                    this.form.reset()
                }
            });
        },
    },
}
</script>