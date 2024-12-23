<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

import InputMask from "primevue/inputmask";
import Password from "primevue/password";

const form = useForm({
    fio: '',
    login: '',
    phone: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Регистрация"/>
        <h1>Регистрация</h1>
        <form @submit.prevent="submit" class="form">
            <div class="form__block">
                <InputLabel for="fio" value="ФИО"/>

                <TextInput
                    id="fio"
                    type="text"
                    v-model="form.fio"
                    required
                    autofocus
                    autocomplete="name"
                    :error="form.errors.fio"
                />

                <InputError :message="form.errors.fio"/>
            </div>

            <div class="form__block">
                <InputLabel for="login" value="Логин"/>

                <TextInput
                    id="login"
                    type="text"
                    v-model="form.login"
                    required
                    autocomplete="username"
                    :error="form.errors.login"
                />

                <InputError :message="form.errors.login"/>
            </div>
            <div class="form__block">
                <InputLabel for="login" value="Телефон"/>

                <InputMask
                    id="phone"
                    class="input"
                    v-model="form.phone"
                    required
                    autocomplete="phone"
                    mask="+7 (999)-999-99-99"
                    placeholder="+7 (999)-999-99-99"
                    :class="{input__error: form.errors.phone}"
                />

                <InputError :message="form.errors.phone"/>
            </div>

            <div class="form__block">
                <InputLabel for="email" value="Email"/>

                <TextInput
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    autocomplete="email"
                    :error="form.errors.email"
                />

                <InputError :message="form.errors.email"/>
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
                    :class="{input__error: form.errors.password}"
                />

                <InputError :message="form.errors.password"/>
            </div>

            <div class="form__block">
                <InputLabel
                    for="password_confirmation"
                    value="Подтверждение пароля"
                />

                <Password
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    toggleMask
                    :feedback="false"
                    required
                    autocomplete="new-password"
                    :class="{input__error: form.errors.password_confirmation}"
                />

                <InputError
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="form__footer">
                <Link
                    :href="route('login')"
                    class="second-link"
                >Вход
                </Link>

                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Зарегистрироваться
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
