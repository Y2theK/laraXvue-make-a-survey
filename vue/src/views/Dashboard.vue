<template>
  <PageComponent title="Dashboard">
    <pre>{{ data }}</pre>
  </PageComponent>
</template>
<script setup>
import PageComponent from "../components/PageComponent.vue";
import { useStore } from "vuex";
import { computed } from "vue";

const store = useStore();

const loading = computed(() => store.state.dashboard.loading);
const data = computed(() => store.state.dashboard.data);

store.dispatch("getDashboardData");
</script>

<style>
</style>