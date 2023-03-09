<!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<template>
  <div>
    <div>
      <img
        class="mx-auto h-12 w-auto"
        src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
        alt="Your Company"
      />
      <h2
        class="mt-6 text-center text-3xl font-bold tracking-tight text-white-900"
      >
        Sign in to your account
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Or
        {{ " " }}
        <router-link
          :to="{ name: 'Login' }"
          class="font-medium text-indigo-600 hover:text-indigo-500"
          >Login to your account</router-link
        >
      </p>
    </div>

    <form class="mt-8 space-y-6" @submit="register">
      <div
        v-if="errorMsg"
        class="py-3 px-4 bg-red-500 text-white rounded flex items-center justify-between"
      >
        {{ errorMsg }}
        <span
          @click="errorMsg = ''"
          class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
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
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </span>
      </div>
      <input type="hidden" name="remember" value="true" />

      <div class="-space-y-px rounded-md shadow-sm">
        <div>
          <label for="fullname" class="sr-only">Full name</label>
          <input
            id="fullname"
            name="fullname"
            type="text"
            autocomplete="fullname"
            required=""
            v-model="user.name"
            class="relative block w-full rounded-t-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            placeholder="Full Name"
          />
        </div>
        <div class="space-y-4">
          <label for="email-address" class="sr-only">Email address</label>
          <input
            id="email-address"
            name="email"
            type="email"
            autocomplete="email"
            required=""
            v-model="user.email"
            class="relative block w-full border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            placeholder="Email address"
          />
        </div>
        <div class="space-y-4">
          <label for="password" class="sr-only">Password</label>
          <input
            id="password"
            name="password"
            type="password"
            autocomplete="current-password"
            required=""
            v-model="user.password"
            class="relative block w-full rounded-b-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            placeholder="Password"
          />
        </div>
        <div class="space-y-4">
          <label for="password_confirmation" class="sr-only">Password</label>
          <input
            id="password_confirmation"
            name="password_confirmation"
            type="password"
            autocomplete="current-password_confirmation"
            required=""
            v-model="user.password_confirmation"
            class="relative block w-full border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            placeholder="Password Confirmation"
          />
        </div>
      </div>

      <div>
        <button
          type="submit"
          class="group relative flex w-full justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
        >
          <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <LockClosedIcon
              class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
              aria-hidden="true"
            />
          </span>
          Sign Up
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import store from "../store";
import { ref } from "vue";
import { useRouter } from "vue-router";
import { LockClosedIcon } from "@heroicons/vue/20/solid";
const errorMsg = ref("");
const user = {
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
};
const router = useRouter();
function register(ev) {
  ev.preventDefault();
  store
    .dispatch("register", user)
    .then(() => {
      router.push({ name: "Dashboard" });
    })
    .catch((err) => {
      errorMsg.value = err.response.data.message;
      console.log(err);
    });
}
</script>



<style>
</style>