<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import Password from "primevue/password";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    login: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Вход"/>
        <h1>Вход</h1>
        <form @submit.prevent="submit" class="form">
            <div class="form__block">
                <InputLabel for="login" value="Логин"/>

                <TextInput
                    id="login"
                    type="text"
                    v-model="form.login"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="login"
                    :error="form.errors.login"
                />

                <InputError :message="form.errors.login"/>
            </div>

            <div class="form__block">
                <InputLabel for="password" value="Пароль"/>

                <Password
                    id="password"
                    v-model="form.password"
                    toggleMask
                    :feedback="false"
                    required
                    autocomplete="current-password"
                    placeholder="password"
                    :error="form.errors.password"
                />

                <InputError :message="form.errors.password"/>
            </div>

            <div class="form__block">
                <label class="checkbox">
                    <Checkbox name="remember" v-model:checked="form.remember"/>
                    <span
                    >Запомнить себя</span
                    >
                </label>
            </div>

            <div class="form__footer">
                <Link
                    :href="route('register')"
                    class="second-link"
                >Регистрация
                </Link>

                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Войти
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

<style scoped>
h1 {
    text-align: center;
    margin-bottom: 2rem;
}
</style>
