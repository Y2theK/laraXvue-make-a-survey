<template>
  <PageComponent>
    <template v-slot:header>
      <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
          {{ route.params.id ? surveyData.title : "Create A Survey" }}
        </h1>
        <button
          @click="deleteSurvey()"
          class="py-2 px-3 text-white bg-red-500 rounded-md hover:bg-red-600"
          type="button"
          v-if="route.params.id"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 -mt-1 inline-block"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
              clip-rule="evenodd"
            />
          </svg>
          Delete Survey
        </button>
      </div>
    </template>
    <div class="flex justify-center" v-if="surveyLoading">Loading ...</div>
    <div v-else>
      <form action="" @submit.prevent="saveSurvey()">
        <!-- {{ model }} -->
        <div class="shadow sm:rounded-md sm:overflow-hidden">
          <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            <div>
              <label for="block text-sm font-medium text-gray-700">Image</label>
              <div class="mt-1 flex items-center">
                <img
                  v-if="surveyData.image_url"
                  :src="surveyData.image_url"
                  :alt="surveyData.title"
                  class="w-64 h-48 object-cover"
                />
                <span
                  v-else
                  class="flex items-center justify-center h-12 w-12 rounded-full overflow-hidden bg-gray-100"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-[80%] h-[80%] text-gray]"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
                    />
                  </svg>
                </span>
                <button
                  type="button"
                  class="relative overflow-hidden ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                  <input
                    type="file"
                    @change="onImageChoose"
                    class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer"
                  />
                  Change
                </button>
              </div>
            </div>
            <!-- Title -->
            <div>
              <label for="title" class="block text-sm font-medium text-gray-700"
                >Title</label
              >
              <input
                type="text"
                name="title"
                id="title"
                v-model="surveyData.title"
                autocomplete="survey_title"
                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
              />
            </div>
            <!--/ Title -->
            <!-- Description -->
            <div>
              <label
                for="about"
                class="block text-sm font-medium text-gray-700"
              >
                Description
              </label>
              <div class="mt-1">
                <textarea
                  id="description"
                  name="description"
                  rows="3"
                  v-model="surveyData.description"
                  autocomplete="survey_description"
                  class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                  placeholder="Describe your survey"
                />
              </div>
            </div>
            <!-- Description -->
            <!-- Expire Date -->
            <div>
              <label
                for="expired_date"
                class="block text-sm font-medium text-gray-700"
                >Expire Date</label
              >
              <input
                type="date"
                name="expired_date"
                id="expired_date"
                v-model="surveyData.expired_date"
                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
              />
            </div>
            <!--/ Expire Date -->
            <!-- Status -->
            <div class="flex items-start">
              <div class="flex items-center h-5">
                <input
                  id="status"
                  name="status"
                  type="checkbox"
                  v-model="surveyData.status"
                  class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                />
              </div>
              <div class="ml-3 text-sm">
                <label for="status" class="font-medium text-gray-700"
                  >Active</label
                >
              </div>
            </div>
            <!--/ Status -->

            <!--/ Survey Fields -->
            <!-- Add new question -->

            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
              <h3
                class="text-2xl font-semibold flex items-center justify-between"
              >
                Questions
                <button
                  type="button"
                  @click="addQuestion()"
                  class="flex items-center text-sm py-1 px-4 text-white bg-[rgba(31,41,55)] rounded-md hover:bg-[#3c4e66]"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                      clip-rule="evenodd"
                    />
                  </svg>
                  Add Question
                </button>
              </h3>
            </div>
            <!--/ Add new question -->
            <div
              v-if="!surveyData.questions || !surveyData.questions.length"
              class="text-center text-gray-600"
            >
              You don't have any questions created
            </div>
            <div
              v-for="(question, index) in surveyData.questions"
              :key="question.id"
            >
              <QuestionEditor
                :question="question"
                :index="index"
                @change="questionChange"
                @addQuestion="addQuestion"
                @deleteQuestion="deleteQuestion"
              />
            </div>

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
              <button
                type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#6366f1] hover:bg-[#3b42f9] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                Save
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../components/PageComponent.vue";
import QuestionEditor from "../components/editor/QuestionEditor.vue";
import store from "../store";
import { computed, ref, watch } from "vue";
import { useRouter, useRoute } from "vue-router";
import { v4 as uuidv4 } from "uuid";
let surveyData = ref({
  title: "",
  status: false,
  description: null,
  image: null,
  image_url: null,
  expired_date: null,
  questions: [],
});

const router = useRouter();
const route = useRoute();

const surveyLoading = computed(() => store.state.currentSurvey.loading);
//watch the current survey and when it change update the surveyData
watch(
  () => store.state.currentSurvey.data,
  (newVal, oldVal) => {
    surveyData.value = {
      ...JSON.parse(JSON.stringify(newVal)),
      status: newVal.status !== "draft",
    };
    // console.log(surveyData.value);
  }
);
// console.log("id", route.params.id);
if (route.params.id) {
  store.dispatch("getSurvey", route.params.id).then((res) => {
    // router.push({
    //   name: "SurveyView",
    //   params: { id: route.params.id },
    // });
  });
  // console.log(surveyData.value);
}
function deleteSurvey() {
  if (confirm("Are you sure to delete?")) {
    store.dispatch("deleteSurvey", route.params.id).then(() => {
      router.push({
        name: "Survey",
      });
    });
  }
}
function addQuestion(index) {
  const newQuestion = {
    id: uuidv4(),
    type: "text",
    question: "",
    description: null,
    data: {},
  };
  // console.log(index);
  surveyData.value.questions.splice(index, 0, newQuestion);
}
function deleteQuestion(question) {
  surveyData.value.questions = surveyData.value.questions.filter(
    (q) => q.id !== question.id
  );
}
function onImageChoose(ev) {
  // console.log(ev.target.files);
  const file = ev.target.files[0];
  const reader = new FileReader(file);
  reader.readAsDataURL(file);
  reader.onload = () => {
    //the file to send backend and apply validation
    surveyData.value.image_url = reader.result;
    //the field to display in fronend
    surveyData.value.image = reader.result;
  };
}
function questionChange(question) {
  surveyData.value.questions = surveyData.value.questions.map((q) => {
    if (q.id === question.id) {
      return JSON.parse(JSON.stringify(question));
    }
    return q;
  });
}
function saveSurvey() {
  // console.log("s d", surveyData.value);
  store.dispatch("saveSurvey", surveyData.value).then((res) => {
    // console.log("saveSurvey res", res);
    store.commit("notify", {
      type: "success",
      message: "Survey was saved successfully...",
    });
    surveyData.image_url = res.data.data.image_url;
    router.push({
      name: "SurveyView",
      params: { id: res.data.data.id },
    });
  });
}
</script>

<style>
</style>