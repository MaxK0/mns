<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from "@inertiajs/vue3";
import {formateInf} from "@/Scripts/formateInf.js";
import {formateDate} from "@/Scripts/formateDate.js";

const props = defineProps({
    application: {
        type: Object,
        required: true
    }
})

const edit = (application) => {
    router.get(route("admin.applications.edit", application));
};

const destroy = (application) => {
    router.delete(route("admin.applications.destroy", application));
};
</script>

<template>
    <Head title="Заявка"></Head>
    <AuthenticatedLayout>
        <section class="admin__application__show">
            <div class="container">
                <div class="section__title">
                    <h2>Просмотр заявки</h2>
                    <div class="section__title__btns">
                        <button
                            class="main-btn"
                            @click="edit(application)"
                        >
                            Изменить
                        </button>
                        <button
                            class="main-btn delete"
                            @click="destroy(application)"
                        >
                            Удалить
                        </button>
                    </div>
                </div>
                <table class="table show__table">
                    <tbody class="tbody">
                    <tr>
                        <th>Пользователь</th>
                        <td>{{ application.user.fio }}</td>
                    </tr>
                    <tr>
                        <th>Услуга</th>
                        <td>{{ application.service ? application.service.title : application.service_inf }}</td>
                    </tr>
                    <tr>
                        <th>Дата оказания услуги</th>
                        <td>{{ formateDate(application.receipt_date) }}</td>
                    </tr>
                    <tr>
                        <th>Адрес</th>
                        <td>{{ application.address }}</td>
                    </tr>
                    <tr>
                        <th>Телефон</th>
                        <td>{{ application.formatted_phone }}</td>
                    </tr>
                    <tr>
                        <th>Почта</th>
                        <td>{{ application.user.email }}</td>
                    </tr>
                    <tr>
                        <th>Статус</th>
                        <td>{{ application.status_label }}</td>
                    </tr>
                    <tr v-if="application.status_label == 'Отменено'">
                        <th>Причина отмены</th>
                        <td v-html="formateInf(application.reason_for_cancel)"></td>
                    </tr>
                    <tr>
                        <th>Тип оплаты</th>
                        <td>{{ application.payment_label }}</td>
                    </tr>
                    <tr>
                        <th>Создан</th>
                        <td>{{ formateDate(application.created_at) }}</td>
                    </tr>
                    <tr>
                        <th>Обновлен</th>
                        <td>{{ formateDate(application.updated_at) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
