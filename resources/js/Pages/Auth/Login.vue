<template>
  <div class="auth-wrapper">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card-style mt-80">
            <div class="text-center mb-30">
              <img src="@/../admin/assets/images/logo/logo.svg" alt="logo" style="height:36px" />
              <h3 class="mt-15">Admin Login</h3>
              <p class="text-sm">Sign in to manage Createlize Bazaar</p>
            </div>

            <form @submit.prevent="submit">
              <div class="input-style-1">
                <label>Email</label>
                <input type="email" v-model="form.email" placeholder="admin@createlize.org" required />
                <div v-if="form.errors.email" class="text-danger text-sm">{{ form.errors.email }}</div>
              </div>
              <div class="input-style-1">
                <label>Password</label>
                <input type="password" v-model="form.password" placeholder="••••••" required />
                <div v-if="form.errors.password" class="text-danger text-sm">{{ form.errors.password }}</div>
              </div>

              <button class="main-btn primary-btn btn-hover w-100" :disabled="form.processing" type="submit">
                {{ form.processing ? 'Signing in...' : 'Sign In' }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
})

function submit() {
  form.post('/admin/login')
}
</script>

<style scoped>
.auth-wrapper{
  min-height:100vh;
  display:flex;
  align-items:center;
}
</style>
