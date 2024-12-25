<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Paginator from "@/Components/Paginator.vue";

import {Head, Link, router} from "@inertiajs/vue3";
import {formateDate} from "@/Scripts/formateDate.js";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Select from 'primevue/select';
import {onUpdated, ref} from "vue";


const props = defineProps({
    applications: {
        type: Object,
        required: true
    },
    statuses: {
        type: Object,
        required: true
    },
    services: {
        type: Object,
        required: true
    },
    status: {
        type: String,
        required: false
    },
    service_id: {
        type: String,
        required: false
    }
});

const isCancelling = ref(false);
const curApplication = ref(null);
const reason_for_cancel = ref('');

console.log(props.status);

const statusFilter = ref(
    props.statuses.find((status) => status.id == props.status)
);

const serviceFilter = ref(
    props.services.find((service) => service.id == props.service_id)
)

const updateStatus = (application) => {
    if (application.status_array.id != 3) {
        router.put(route("admin.applications.status.update", application), {
            status: application.status_array.id
        });
    } else {
        isCancelling.value = true;
        curApplication.value = application;
    }
};

const closeModal = () => {
    isCancelling.value = false;

    curApplication.value.status_array = props.statuses.find((status) => status.id == curApplication.value.status);
};

const updateStatusWithReason = () => {
    router.put(route("admin.applications.status.update", curApplication.value), {
        status: curApplication.value.status_array.id,
        reason_for_cancel: reason_for_cancel.value
    });
};

const edit = (application) => {
    router.get(route("admin.applications.edit", application));
};

const destroy = (application) => {
    router.delete(route("admin.applications.destroyWithoutRedirect", application));
};

const fetchApplications = () => {
    router.get(route("admin.applications.index", {
        status: statusFilter.value.id,
        service_id: serviceFilter.value.id
    }));
};

onUpdated(() => {
    isCancelling.value = false;
    fetchApplications();
});
</script>

<template>
    <Head title="Заявки"></Head>
    <AuthenticatedLayout>
        <div v-if="isCancelling" class="modal-overlay" @click="closeModal">
            <div class="modal" @click.stop>
                <h3>Причина отмены</h3>
                <TextInput
                    id="reason_for_cancel"
                    type="text"
                    v-model="reason_for_cancel"
                    required
                    placeholder="Введите причину отмены"
                />
                <PrimaryButton
                    @click="updateStatusWithReason"
                >
                    OK
                </PrimaryButton>
            </div>
        </div>
        <section class="admin__application__index">
            <div class="container">
                <div class="section__title">
                    <h2>Заявки</h2>
                    <div class="section__title__btns">
                        <Select
                            v-model="statusFilter"
                            :options="statuses"
                            filter
                            optionLabel="label"
                            placeholder="Выберите статус"
                            class="select"
                            @change="fetchApplications"
                        >
                        </Select>
                        <Select
                            v-model="serviceFilter"
                            :options="services"
                            filter
                            optionLabel="title"
                            placeholder="Выберите услугу"
                            class="select"
                            @change="fetchApplications"
                        >
                        </Select>
                    </div>
                </div>
                <table v-if="applications.data.length" class="table table__index">
                    <thead class="thead thead__index">
                    <tr>
                        <th>Пользователь</th>
                        <th>Услуга</th>
                        <th>Оказание услуги</th>
                        <th>Телефон</th>
                        <th>Адрес</th>
                        <th>Статус</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="tbody tbody__index">
                    <tr v-for="(application, id) in applications.data" :key="id">
                        <td data-label="ФИО">
                            <Link
                                :href="route('admin.applications.show', application)"
                                class="main-link"
                            > {{ application.user.fio }}
                            </Link>
                        </td>
                        <td data-label="Услуга" class="table-inf">
                            {{ application.service ? application.service.title : application.service_inf }}
                        </td>
                        <td data-label="Оказание услуги">
                            {{ formateDate(application.receipt_date) }}
                        </td>
                        <td data-label="Телефон">
                            {{ application.formatted_phone }}
                        </td>
                        <td data-label="Адрес">
                            {{ application.address }}
                        </td>
                        <td data-label="Статус">
                            <Select
                                id="status"
                                v-model="application.status_array"
                                :options="statuses"
                                filter
                                optionLabel="label"
                                class="select"
                                style="padding: 0.6rem 0.8rem"
                                required
                                @change="updateStatus(application)"
                            ></Select>
                        </td>
                        <td data-label="">
                            <div class="table__btns">
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
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p v-else>Нет заявок</p>
                <Paginator :pagination="applications"/>
            </div>
        </section>
    </AuthenticatedLayout>
</template>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5); /* Затемнение фона */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000; /* Обеспечивает, что модальное окно выше других элементов */
}

.modal {
    background-color: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 30rem;
    text-align: center;
}

.modal .input {
    border-color: #2a282d;
    color: #2a282d;
    margin-bottom: 2rem;
}

.modal h3 {
    color: #2a282d;
    margin-bottom: 3rem;
}
</style>
