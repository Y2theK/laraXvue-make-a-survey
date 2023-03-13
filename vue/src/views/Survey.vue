<template>
  <PageComponent>
    <template v-slot:header></template>
    <div class="flex justify-between items-center">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900">Survey</h1>
      <router-link
        :to="{ name: 'SurveyCreate' }"
        class="py-2 px-3 text-white flex bg-[rgba(31,41,55)] rounded-md hover:bg-[#3c4e66]"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-6 h-6"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 4.5v15m7.5-7.5h-15"
          />
        </svg>
        Add New Survey
      </router-link>
    </div>
    <div class="flex justify-center" v-if="surveys.loading">Loading...</div>
    <div v-else class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
      <SurveyListItem
        v-for="(survey, index) in surveys.data"
        :key="survey.id"
        class="opacity-0 animate-fade-in-down"
        :style="{ animationDelay: `${index * 0.1}s` }"
        :survey="survey"
        @delete="deleteSurvey(survey)"
      />
    </div>
  </PageComponent>
</template>
<script setup>
import PageComponent from "../components/PageComponent.vue";
import SurveyListItem from "../components/SurveyListItem.vue";
import store from "../store";
import { computed } from "vue";

store.dispatch("getSurveys");
const surveys = computed(() => store.state.surveys);
function deleteSurvey(survey) {
  if (confirm("Are you sure to delete this survey?")) {
    //delete survey
    store.dispatch("deleteSurvey", survey.id).then(() => {
      store.dispatch("getSurveys");
    });
  }
}
</script>

<style>
</style>