<template>
    <div class="container pt-2">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Authentication</div>

                    <div class="card-body">
                        <tabs>
                            <tab name="Sign in" :selected="true">
                                <form @keydown="loginForm.errors.clear($event.target.name)">
                                    <div class="alert alert-danger" v-if="loginForm.errors.message">
                                        <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                                        <p class="mb-0">{{ loginForm.errors.message }}</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="loginEmail">Email address</label>
                                        <input v-model="loginForm.email" name="email" type="email" class="form-control" id="loginEmail" aria-describedby="emailHelp" placeholder="Enter email">
                                        <small class="form-text text-danger" v-show="loginForm.errors.has('email')">{{ loginForm.errors.get('email') }}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="loginPassword">Password</label>
                                        <input v-model="loginForm.password" name="password" type="password" class="form-control" id="loginPassword" placeholder="Password">
                                        <small class="form-text text-danger" v-show="loginForm.errors.has('password')">{{ loginForm.errors.get('password') }}</small>
                                    </div>
                                    <!--<div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                    </div>-->
                                    <button type="submit" class="btn btn-primary" :disabled="loginForm.errors.any()" @click.prevent="login">Log in</button>
                                </form>
                            </tab>

                            <tab name="Registration">
                                <form @keydown="registerForm.errors.clear($event.target.name)">
                                    <div class="alert alert-danger" v-if="registerForm.errors.message">
                                        <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                                        <p class="mb-0">{{ registerForm.errors.message }}</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="registerEmail">Email address</label>
                                        <input v-model="registerForm.email" name="email" type="email" class="form-control" id="registerEmail" placeholder="Enter email">
                                        <small class="form-text text-danger" v-show="registerForm.errors.has('email')">{{ registerForm.errors.get('email') }}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="registerName">Name</label>
                                        <input v-model="registerForm.name" name="name" type="text" class="form-control" id="registerName" placeholder="Enter name">
                                        <small class="form-text text-danger" v-show="registerForm.errors.has('name')">{{ registerForm.errors.get('name') }}</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="registerPassword">Password</label>
                                        <input v-model="registerForm.password" name="password" type="password" class="form-control" id="registerPassword" placeholder="Password">
                                        <small class="form-text text-danger" v-show="registerForm.errors.has('password')">{{ registerForm.errors.get('password') }}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="registerPasswordConfirmation">Password confirmation</label>
                                        <input v-model="registerForm.password_confirmation" @keydown="registerForm.errors.clear('password')" type="password" class="form-control" id="registerPasswordConfirmation" placeholder="Confirm your password">
                                    </div>

                                    <button type="submit" class="btn btn-primary" :disabled="registerForm.errors.any()" @click.prevent="register">Sign up</button>
                                </form>
                            </tab>
                        </tabs>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Tabs from './Tabs.vue';
    import Tab from './Tab.vue';
    import Form from "../classes/Form";
    export default {
        name: "Authentication",
        components: {
            Tabs,
            Tab
        },
        data() {
            return {
                loginForm: new Form({
                    email: '',
                    password: '',
                }),

                registerForm: new Form({
                    email: '',
                    name: '',
                    password: '',
                    password_confirmation: '',
                }),
            }
        },

        methods: {
            login() {
                this.loginForm.post('/api/v1/login').then(response => {
                    this.onAuthSuccess(response);
                });
            },

            register() {
                this.registerForm.post('/api/v1/register').then(response => {
                    this.onAuthSuccess(response);
                });
            },

            onAuthSuccess(response) {
                localStorage.accessToken = response.data.data.token.access_token;
                window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.accessToken;
                EventVue.$emit('resetGlobal');
            },
        },
    }
</script>

<style scoped>

</style>