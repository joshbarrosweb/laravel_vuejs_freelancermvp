<template>
    <jet-form-section @submitted="store">
        <template #title>
            Criar Usuário
        </template>

        <template #description>
            Criar um novo Usuário.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Nome" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="E-mail" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" autofocus />
                <jet-input-error :message="form.errors.email" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="city" value="Cidade" />
                <jet-input id="city" type="text" class="mt-1 block w-full" v-model="form.city" autofocus />
                <jet-input-error :message="form.errors.city" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="formation" value="Formação" />
                <jet-input id="formation" type="text" class="mt-1 block w-full" v-model="form.formation" autofocus />
                <jet-input-error :message="form.errors.formation" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="linkedin" value="LinkedIn" />
                <jet-input id="linkedin" type="text" class="mt-1 block w-full" v-model="form.linkedin" autofocus />
                <jet-input-error :message="form.errors.linkedin" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="whatsapp" value="WhatsApp" />
                <jet-input id="whatsapp" type="text" class="mt-1 block w-full" v-model="form.whatsapp" autofocus />
                <jet-input-error :message="form.errors.whatsapp" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="skills" value="Especializações" />
                <jet-input id="skills" type="text" class="mt-1 block w-full" v-model="form.skills" autofocus />
                <jet-input-error :message="form.errors.skills" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="username" value="Apelido" />
                <jet-input id="username" type="text" class="mt-1 block w-full" v-model="form.username" autofocus />
                <jet-input-error :message="form.errors.username" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="role_id" value="Hierarquia" />
                <jet-input id="role_id" type="text" class="mt-1 block w-full" v-model="form.role_id" autofocus />
                <jet-input-error :message="form.errors.role_id" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Usuário criado.
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
                name: '',
                email: '',
                city: '',
                formation: '',
                linkedin: '',
                whatsapp: '',
                skills: '',
                username: '',
                role_id: '',
            })
        }
    },
    methods: {
        store() {
            this.form.post(route('admin.users.store'), {
                errorBag: 'userStore',
                preserveScroll: true,
                onSuccess: () => {
                    this.form.reset()
                }
            });
        },
    },
}
</script>
