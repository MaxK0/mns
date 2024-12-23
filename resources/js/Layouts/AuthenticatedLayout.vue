<script setup>
import NavLink from '@/Components/NavLink.vue';
import {Link} from '@inertiajs/vue3';
</script>

<template>
    <div class="top__main">
        <header class="header">
            <div class="container header__container">
                <nav class="header__nav">
                    <Link :href="route('applications.index')">
                        <h1>mns</h1>
                    </Link>
                    <ul class="header__ul">
                        <li v-if="$page.props.auth.user.is_admin" class="header__li">
                            <NavLink :href="route('applications.index')" :active="route().current('applications.*')">
                                Админка
                            </NavLink>
                        </li>
                        <li class="header__li">
                            <Link class="nav__link" :href="route('logout')" method="post" as="button">
                                Выйти
                            </Link>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="main">
            <slot/>
        </main>
    </div>
</template>

<style scoped>
.top__main {
    min-height: 100vh;
}

.main {
    margin-top: 2.8rem;
}

h1 {
    font-size: var(--font-size-large);
    color: var(--color-main);
}
</style>
