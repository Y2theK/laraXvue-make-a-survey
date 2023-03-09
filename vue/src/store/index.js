import axios from "axios";
import { createStore } from "vuex";
import axiosClient from "../axios";
const store = createStore({
    state: {
        user: {
            data: {},
            token: sessionStorage.getItem("TOKEN"),
        },
    },
    getters: {},
    mutations: {
        logout: (state) => {
            state.user.data = {};
            state.user.token = null;
        },
        setUser: (state, userData) => {
            state.user.data = userData.user;
            state.user.token = userData.token;
            sessionStorage.setItem("TOKEN", userData.token);
        },
    },
    actions: {
        register({ commit }, user) {
            return fetch("http://127.0.0.1:8000/api/register", {
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                method: "POST",
                body: JSON.stringify(user),
            })
                .then((res) => res.json())
                .then((res) => {
                    commit("setUser", res);
                    return res;
                });
        },
        login({ commit }, user) {
            //method 1
            // return fetch("http://127.0.0.1:8000/api/login", {
            //     headers: {
            //         "Content-Type": "application/json",
            //         Accept: "application/json",
            //     },
            //     method: "POST",
            //     body: JSON.stringify(user),
            // })
            //     .then((res) => res.json())
            //     .then((res) => {
            //         commit("setUser", res);
            //         return res;
            //     });

            //method 2
            // return axios
            //     .post("http://127.0.0.1:8000/api/login", user)
            //     .then((res) => {
            //         commit("setUser", res);
            //         return res;
            //     });

            //method 3
            return axiosClient.post("/login", user).then(({ data }) => {
                commit("setUser", data);
                return data;
            });
        },
    },
    modules: {},
});
export default store;
