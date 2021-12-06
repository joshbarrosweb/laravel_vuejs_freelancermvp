<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
            Informação do Perfil
        </template>

        <template #description>
            Atualize as informações do perfil da sua conta e o endereço de e-mail.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-4" v-if="$page.props.jetstream.managesProfilePhotos">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview">

                <jet-label for="photo" value="Imagem" />

                <!-- Current Profile Photo -->
                <div class="mt-2" v-if="! photoPreview">
                    <img :src="user.profile_photo_url" :alt="user.name" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" v-if="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div> 

                <jet-secondary-button class="mt-2 mr-2" type="button" @click.native.prevent="selectNewPhoto">
                    Selecione uma nova Foto
                </jet-secondary-button>

                <jet-secondary-button type="button" class="mt-2" @click.native.prevent="deletePhoto" v-if="user.profile_photo_path">
                    Remover Foto
                </jet-secondary-button>

                <jet-input-error :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Nome" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                <jet-input-error :message="form.errors.email" class="mt-2" />
            </div>

            <!-- Username -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="username" value="Apelido" />
                <jet-input id="username" type="text" class="mt-1 block w-full" v-model="form.username" autocomplete="username" />
                <jet-input-error :message="form.errors.username" class="mt-2" />
            </div>

            <!-- City -->
            <div v-if="$page.props.auth.user.role_id==3" class="col-span-6 sm:col-span-4">
                <jet-label for="city" value="Cidade" />
                <jet-input id="city" type="text" class="mt-1 block w-full" v-model="form.city" autocomplete="city" />
                <jet-input-error :message="form.errors.city" class="mt-2" />
            </div>

            <!-- Formation -->
            <div v-if="$page.props.auth.user.role_id==3" class="col-span-6 sm:col-span-4">
                <jet-label for="formation" value="Formação" />
                <jet-input id="formation" type="text" class="mt-1 block w-full" v-model="form.formation" autocomplete="formation" />
                <jet-input-error :message="form.errors.formation" class="mt-2" />
            </div>

            <!-- LinkedIn -->
            <div v-if="$page.props.auth.user.role_id==3" class="col-span-6 sm:col-span-4">
                <jet-label for="linkedin" value="LinkedIn" />
                <jet-input id="linkedin" type="text" class="mt-1 block w-full" v-model="form.linkedin" autocomplete="linkedin" />
                <jet-input-error :message="form.errors.linkedin" class="mt-2" />
            </div>

            <!-- WhatsApp -->
            <div v-if="$page.props.auth.user.role_id==3" class="col-span-6 sm:col-span-4">
                <jet-label for="whatsapp" value="WhatsApp" />
                <jet-input id="whatsapp" type="text" class="mt-1 block w-full" v-model="form.whatsapp" autocomplete="whatsapp" />
                <jet-input-error :message="form.errors.whatsapp" class="mt-2" />
            </div>

            <!-- Skills -->
            <div v-if="$page.props.auth.user.role_id==3" class="col-span-6 sm:col-span-4">
                <jet-label for="skills" value="Especialidades" />
                <jet-input id="skills" type="text" class="mt-1 block w-full" v-model="form.skills" autocomplete="skills" />
                <jet-input-error :message="form.errors.skills" class="mt-2" />
            </div>

            <!-- CPF
            <div v-if="$page.props.auth.user.role_id==3" class="col-span-6 sm:col-span-4">
                <jet-label for="cpf" value="CPF" />
                <jet-input id="cpf" type="text" class="mt-1 block w-full" v-model="form.cpf" autocomplete="cpf" />
                <jet-input-error :message="form.errors.cpf" class="mt-2" />
            </div> -->

            <!-- CNPJ
            <div v-if="$page.props.auth.user.role_id==2" class="col-span-6 sm:col-span-4">
                <jet-label for="cnpj" value="CNPJ" />
                <jet-input id="cnpj" type="text" class="mt-1 block w-full" v-model="form.cnpj" autocomplete="cnpj" />
                <jet-input-error :message="form.errors.cnpj" class="mt-2" />
            </div> -->

        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        props: ['user'],

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'PUT',
                    name: this.user.name,
                    email: this.user.email,
                    username: this.user.username,
                    city: this.user.city,
                    formation: this.user.formation,
                    linkedin: this.user.linkedin,
                    whatsapp: this.user.whatsapp,
                    skills: this.user.skills,
                    //cpf: this.user.cpf,
                    //cnpj: this.user.cnpj,
                    photo: null,
                }),

                photoPreview: null,
            }
        },

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    errorBag: 'updateProfileInformation',
                    preserveScroll: true,
                    onSuccess: () => (this.clearPhotoFileInput()),
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const photo = this.$refs.photo.files[0];

                if (! photo) return;

                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(photo);
            },

            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.photoPreview = null;
                        this.clearPhotoFileInput();
                    },
                });
            },

            clearPhotoFileInput() {
                if (this.$refs.photo?.value) {
                    this.$refs.photo.value = null;
                }
            },
        },
    }
</script>
