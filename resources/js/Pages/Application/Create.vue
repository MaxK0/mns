<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref} from "vue";
import {Head, useForm} from "@inertiajs/vue3";
import {usePage} from "@inertiajs/vue3";

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputMask from "primevue/inputmask";
import Select from 'primevue/select';
import Checkbox from "@/Components/Checkbox.vue";

const page = usePage();

const props = defineProps({
    services: {
        type: Object,
        required: true
    },
    paymentTypes: {
        type: Object,
        required: true
    }
});

const form = useForm({
    service: [],
    is_another_service: false,
    service_inf: '',
    phone: page.props.auth.user.formatted_phone,
    address: '',
    receipt_date: null,
    payment_type: undefined
});

const submit = () => {
    form.post(route('applications.store'));
};
</script>

<template>
    <Head title="Создание заявки"></Head>
    <AuthenticatedLayout>
        <section class="application__create">
            <div class="container">
                <h2>Создание заявки</h2>
                <form @submit.prevent="submit" class="form">
                    <div class="form__blocks">
                        <div v-if="form.is_another_service" class="form__block">
                            <InputLabel for="service_inf" value="Услуга" />
                            <textarea
                                id="service_inf"
                                class="textarea"
                                v-model="form.service_inf"
                                rows="3"
                                placeholder="Опишите свою услугу"
                                required
                                :class="{input__error: form.errors.service_inf}"
                            >

                            </textarea>
                            <InputError :message="form.errors.service_inf" />
                        </div>
                        <div v-else class="form__block">
                            <InputLabel for="service" value="Услуга" />
                            <Select
                                id="service"
                                v-model="form.service"
                                :options="services"
                                filter
                                optionLabel="title"
                                placeholder="Выберите услугу"
                                class="select"
                                required
                                :class="{input__error: form.errors.service_id}"
                            >
                            </Select>
                            <InputError :message="form.errors.service_id" />
                        </div>
                        <div class="form__block">
                            <label class="checkbox">
                                <Checkbox id="is_another_service" v-model:checked="form.is_another_service"/>
                                <span
                                >Иная услуга</span
                                >
                            </label>
                        </div>
                    </div>

                    <div class="form__blocks">
                        <div class="form__block">
                            <InputLabel for="phone" value="Телефон"/>

                            <InputMask
                                id="phone"
                                class="input"
                                v-model="form.phone"
                                autocomplete="phone"
                                mask="+7 (999)-999-99-99"
                                placeholder="+7 (999)-999-99-99"
                                required
                                :class="{input__error: form.errors.phone}"
                            />

                            <InputError :message="form.errors.phone"/>
                        </div>

                        <div class="form__block">
                            <InputLabel for="address" value="Адрес"/>

                            <TextInput
                                id="address"
                                type="text"
                                v-model="form.address"
                                required
                                autocomplete="address"
                                placeholder="Улица 1, д. 1, кв. 1"
                                :error="form.errors.address"
                            />

                            <InputError :message="form.errors.address"/>
                        </div>
                    </div>

                    <div class="form__blocks">
                        <div class="form__block">
                            <InputLabel for="payment_type" value="Тип оплаты" />
                            <Select
                                id="payment_type"
                                v-model="form.payment_type"
                                :options="paymentTypes"
                                filter
                                optionLabel="label"
                                placeholder="Выберите тип"
                                class="select"
                                required
                                :class="{input__error: form.errors.payment_type}"
                            >
                            </Select>
                            <InputError :message="form.errors.payment_type" />
                        </div>

                        <div class="form__block">
                            <InputLabel for="receipt_date" value="Оказание услуги"/>

                            <TextInput
                                id="receipt_date"
                                type="datetime-local"
                                v-model="form.receipt_date"
                                required
                                :error="form.errors.receipt_date"
                            />

                            <InputError :message="form.errors.receipt_date"/>
                        </div>
                    </div>

                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Создать
                    </PrimaryButton>
                </form>
            </div>
        </section>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
