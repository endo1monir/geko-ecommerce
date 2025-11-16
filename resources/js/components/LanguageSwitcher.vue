<template>
    <div class="flex items-center gap-2">
        <button v-for="locale in locales" :key="locale"
        :class="{'font-bold text-blue-600' : currentLocale === locale}"
        @click="switchLocale(locale)"
        >
{{ locale.toUpperCase() }}
        </button>
    </div>
</template>
<script setup>
import { router } from '@inertiajs/vue3';

const locales=['ar','en'];
const currentLocale= document.documentElement.lang;
const switchLocale =(locale)=>{
    router.visit(`/lang/${locale}`, { preserveScroll: true })
}
</script>