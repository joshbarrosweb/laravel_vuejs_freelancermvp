<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <jet-validation-errors class="mb-2" />

        <form @submit.prevent="submit">
            <div>
                <jet-label for="name" value="Nome" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
            </div>

            <div class="mt-1">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
            </div>

            <div v-if="form.role_id == 3" class="mt-1">
                <jet-label for="city" value="Cidade" />
                <jet-input id="city" type="text" class="mt-1 block w-full" v-model="form.city" required autofocus autocomplete="city" />
            </div>

            <div v-if="form.role_id == 3" class="mt-1">
                <jet-label for="formation" value="Formação" />
                <jet-input id="formation" type="text" class="mt-1 block w-full" v-model="form.formation" required autofocus autocomplete="formation" />
            </div>

            <div v-if="form.role_id == 3" class="mt-1">
                <jet-label for="linkedin" value="LinkedIn" />
                <jet-input id="linkedin" type="text" class="mt-1 block w-full" v-model="form.linkedin" required autofocus autocomplete="linkedin" />
            </div>

            <div v-if="form.role_id == 3" class="mt-1">
                <jet-label for="whatsapp" value="WhatsApp" />
                <jet-input id="whatsapp" type="text" class="mt-1 block w-full" v-model="form.whatsapp" required autofocus autocomplete="whatsapp" />
            </div>

            <div v-if="form.role_id == 3" class="mt-1">
                <jet-label for="skills" value="Especialidades" />
                <jet-input id="skills" type="text" class="mt-1 block w-full" v-model="form.skills" required autofocus autocomplete="skills" />
            </div>

            <div v-if="form.role_id == 3">
                <jet-label for="cpf" value="CPF" />
                <jet-input id="cpf" type="text" class="mt-1 block w-full" v-model="form.cpf" autofocus autocomplete="cpf" />
            </div>

            <div v-if="form.role_id == 2">
                <jet-label for="cnpj" value="CNPJ" />
                <jet-input id="cnpj" type="text" class="mt-1 block w-full" v-model="form.cnpj" autofocus autocomplete="cnpj" />
            </div>

            <div class="mt-1">
                <jet-label for="password" value="Senha" />
                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
            </div>

            <div class="mt-1">
                <jet-label for="password_confirmation" value="Confirmação de Senha" />
                <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-1">
                <jet-label for="role_id" value="Registrar como: " />
                <select name="role_id" v-model="form.role_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="2">Empresa</option>
                    <option value="3" selected>Freelancer</option>
                </select>
            </div>

            <div class="mt-1" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                <jet-label for="terms">
                    <div class="flex items-center">
                        <jet-checkbox name="terms" id="terms" v-model:checked="form.terms" />

                        <div class="ml-2">
                            Eu concordo com os <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Termos de Serviço</a> e <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Politica de Privacidade</a>
                        </div>
                    </div>
                </jet-label>
            </div>

            <div class="flex items-center justify-end mt-2">
                <inertia-link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Ja é registrado?
                </inertia-link>

                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrar!
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from "@/Jetstream/Checkbox";
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors
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
                    cpf: '',
                    cnpj: '',
                    password: '',
                    password_confirmation: '',
                    role_id: '3',
                    terms: false,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
