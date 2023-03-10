<template>
  <div>
    <div class="flex items-center justify-between">
      <h3 class="text-lg font-bold">{{ index + 1 }}. {{ model.question }}</h3>
      <div class="flex items-center justify-center">
        <button
          type="button"
<<<<<<< HEAD
          class="flex items-center text-xs py-1 px-3 mr-2 text-white bg-[rgba(31,41,55)] rounded-md hover:bg-[#3c4e66]"
=======
          class="flex items-center text-xs py-1 px-3 mr-2 rounded-sm text-white bg-gray-600 hover:bg-gray-700"
>>>>>>> 5bc42c34b93d3dcce87c68402ee361e1db880b61
          @click="addQuestion()"
        >
          Add
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
        </button>
        <button
          type="button "
          @click="deleteQuestion()"
<<<<<<< HEAD
          class="flex items-center text-xs py-1 px-3 rounded-md border border-transparent text-red-500 hover:border-red-600"
=======
          class="flex items-center text-xs py-1 px-3 rounded-sm border border-transparent text-red-500 hover:border-red-600"
>>>>>>> 5bc42c34b93d3dcce87c68402ee361e1db880b61
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
              clip-rule="evenodd"
            />
          </svg>
          Delete
        </button>
      </div>
    </div>

    <div class="grid gap-3 grid-cols-12">
      <div class="mt-3 col-span-9">
        <label
          for="'question_text_'+model.data"
          class="block text-sm font-medium text-gray-700"
        >
          Question Text</label
        >
        <input
          type="text"
          :name="'question_text' + model.data"
          v-model="model.question"
          @change="dataChange"
          :id="'question_text' + model.data"
          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
        />
      </div>
      <div class="mt-3 col-span-3">
        <label
          for="question_type"
          class="block text-sm font-medium text-gray-700"
          >Select Question Type</label
        >
        <select
          id="question_type"
          class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          v-model="model.type"
          @change="typeChange()"
        >
          <option v-for="type in questionTypes" :key="type" :value="type">
            {{ upperCaseFirst(type) }}
          </option>
        </select>
      </div>
    </div>
    <div class="mt-3 col-span-9">
      <label
        :for="'question_description_' + model.id"
        class="block text-sm font-medium text-gray-700"
        >Description</label
      >
      <textarea
        :name="'question_description_' + model.id"
        v-model="model.description"
        @change="dataChange"
        :id="'question_description_' + model.id"
        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
      />
    </div>
    <div>
      <div v-if="shouldHaveOptions()" class="mt-2">
        <h4
          class="text-sm font-semibold mb-1 flex justify-between items-center"
        >
          Options

          <!-- Add new option -->
          <button
            type="button"
            @click="addOption()"
            class="flex items-center text-xs py-1 px-2 bg-[rgba(31,41,55)] rounded-md hover:bg-[#3c4e66] text-white"
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
            Add Option
          </button>
          <!--/ Add new option -->
        </h4>
        <div
          v-if="!model.data.options || !model.data.options.length"
          class="text-xs text-gray-600 text-center py-3"
        >
          You don't have any options defined
        </div>
        <div
          v-for="(option, index) in model.data.options"
          :key="option.uuid"
          class="flex items-center mb-1"
        >
          <span class="w-6 text-sm"> {{ index + 1 }}. </span>
          <input
            type="text"
            v-model="option.text"
            @change="dataChange"
            class="w-full rounded-sm py-1 px-2 text-xs border border-gray-300 focus:border-indigo-500"
          />
          <!-- Delete Option -->
          <button
            type="button"
            @click="removeOption(option)"
            class="h-6 w-6 rounded-full flex items-center justify-center border border-transparent transition-colors hover:border-red-100"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-3 w-3 text-red-500"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                clip-rule="evenodd"
              />
            </svg>
          </button>
          <!--/ Delete Option -->
        </div>
      </div>
    </div>
    <hr class="my-12" />
  </div>
</template>

<script setup>
import { ref } from "vue";
import { v4 as uuidv4 } from "uuid";
import store from "../../store";
import { computed } from "vue";
const props = defineProps({
  question: Object,
  index: Number,
});

const emit = defineEmits(["change", "addQuestion", "deleteQuestion"]);

//recreate the whole question data to avoid unintentional reference change
const model = ref(JSON.parse(JSON.stringify(props.question)));
// console.log(model);
//get questionTypes from vuex
const questionTypes = computed(() => store.state.questionTypes);

function upperCaseFirst(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}
// check if the question should have options or not
function shouldHaveOptions() {
  return ["radio", "select", "checkbox"].includes(model.value.type);
}
function getOptions() {
  return model.value.data.options;
}
function setOptions(options) {
  model.value.data.options = options;
}
function addOption() {
  setOptions([...getOptions(), { uuid: uuidv4(), text: "" }]);
  dataChange();
}
function removeOption(option) {
  setOptions(getOptions().filter((opt) => opt !== option));
  dataChange();
}
function typeChange() {
  if (shouldHaveOptions()) {
    setOptions(getOptions() || []);
  }
  dataChange();
}
function dataChange() {
  // not to delete the real options yet, create new data with model value
  const data = JSON.parse(JSON.stringify(model.value));
  // console.log(data);
  if (!shouldHaveOptions()) {
    delete data.data.options;
  }

  emit("change", data);
}

function deleteQuestion() {
  emit("deleteQuestion", props.question);
}
function addQuestion() {
  emit("addQuestion", props.index + 1);
}
</script>

<style>
</style>