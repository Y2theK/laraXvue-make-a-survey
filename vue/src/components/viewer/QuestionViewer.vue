<template>
  <fieldset class="mb-4">
    <div>
      <legend class="text-base font-medium text-gray-900">
        {{ index + 1 }}.{{ question.question }}
      </legend>
      <p class="text-gray-500 text-sm">
        {{ question.description }}
      </p>
    </div>
    <div class="mt-3">
      <div v-if="question.type === 'radio'">
        <div
          v-for="option in question.data.options"
          :key="option.uuid"
          class="flex items-center"
        >
          <input
            type="radio"
            :name="'question' + question.id"
            :id="option.uuid"
            :value="option.text"
            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
            @change="emits('update:modelValue', $event.target.value)"
          />
          <label
            :for="option.uuid"
            class="ml-3 block text-sm font-medium text-gray-700"
            >{{ option.text }}</label
          >
        </div>
      </div>
      <div v-else-if="question.type === 'checkbox'">
        {{ model }}
        <div
          v-for="option in question.data.options"
          :key="option.uuid"
          class="flex items-center"
        >
          <input
            type="checkbox"
            name=""
            :id="option.uuid"
            @change="onCheckboxChange"
            v-model="model[option.text]"
            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
          />
          <label
            :for="option.uuid"
            class="ml-3 block text-sm font-medium text-gray-700"
            >{{ option.text }}</label
          >
        </div>
      </div>
      <div v-else-if="question.type === 'select'">
        <select
          class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          name=""
          id=""
          :value="modelValue"
          @change="emits('update:modelValue', $event.target.value)"
        >
          <option value="">Please select</option>
          <option
            :value="option.text"
            v-for="option in question.data.options"
            :key="option.uuid"
          >
            {{ option.text }}
          </option>
        </select>
      </div>
      <div v-else-if="question.type === 'text'">
        <input
          type="text"
          :value="modelValue"
          @input="emits('update:modelValue', $event.target.value)"
          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
        />
      </div>
      <div v-else-if="question.type === 'textarea'">
        <textarea
          :value="modelValue"
          @input="emits('update:modelValue', $event.target.value)"
          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
        ></textarea>
      </div>
    </div>
    <hr class="my-4" />
  </fieldset>
</template>

<script setup>
import { ref } from "vue";
const { question, index, modelValue } = defineProps({
  question: Object,
  index: Number,
  modelValue: [String, Object], //if you passed the model from parent, you can get from modelValue
});
const emits = defineEmits(["update:modelValue"]); //return the modelValue back to parent     //2 ways binding
function onCheckboxChange() {
  const selectedOptions = [];
  for (let text in model.value) {
    if (model.value[text]) {
      selectedOptions.push(text);
    }
  }
  emits("update:modelValue", selectedOptions);
}
console.log(question, index, modelValue);
let model;
// checkbox can have multiple answers
if (question.type === "checkbox") {
  model = ref({});
}
</script>

<style>
</style>