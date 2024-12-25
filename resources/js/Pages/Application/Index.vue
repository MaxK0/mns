<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Paginator from "@/Components/Paginator.vue";

import {Link, Head} from "@inertiajs/vue3";
import {formateDate} from "@/Scripts/formateDate.js";

const props = defineProps({
    applications: {
        type: Object,
        required: true
    }
});


</script>

<template>
    <Head title="Заявки"></Head>
    <AuthenticatedLayout>
        <section class="application__index">
            <div class="container">
                <div class="section__title">
                    <h2>История заявок</h2>
                    <div class="section__title__btns">
                        <Link
                            :href="route('applications.create')"
                            class="main-btn"
                        >Создать
                        </Link>
                    </div>
                </div>
                <table v-if="applications.data.length" class="table table__index">
                    <thead class="thead thead__index">
                    <tr>
                        <th>Услуга</th>
                        <th>Дата оказания услуги</th>
                        <th>Телефон</th>
                        <th>Статус</th>
                    </tr>
                    </thead>
                    <tbody class="tbody tbody__index">
                    <tr v-for="(application, id) in applications.data" :key="id">
                        <td data-label="Услуга" class="table-inf">
                            <Link
                                :href="route('applications.show', application)"
                                class="main-link"
                            >{{ application.service ? application.service.title : application.service_inf }}
                            </Link>
                        </td>
                        <td data-label="Оказание услуги">
                            {{ formateDate(application.receipt_date) }}
                        </td>
                        <td data-label="Телефон">
                            {{ application.formatted_phone }}
                        </td>
                        <td data-label="Статус">
                            {{ application.status_label }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p v-else>У вас нет заявок</p>
                <Paginator :pagination="applications"/>
            </div>
        </section>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
