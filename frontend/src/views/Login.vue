<template>
  <div class="min-h-screen bg-slate-50 p-6">
    <div class="mx-auto mt-20 w-full max-w-md rounded-xl border border-slate-200 bg-white p-8 shadow-sm">
      <h1 class="mb-6 text-2xl font-semibold text-slate-900">Patient login</h1>
      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label class="mb-1 block text-sm font-medium text-slate-700">Login (FirstnameSurname)</label>
          <input
            v-model="form.login"
            placeholder="PiotrKowalski"
            required
            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
          />
        </div>
        <div>
          <label class="mb-1 block text-sm font-medium text-slate-700">
            Password (birth date YYYY-MM-DD)
          </label>
          <input
            v-model="form.password"
            placeholder="1983-04-12"
            required
            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-slate-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
          />
        </div>
        <p v-if="error" class="text-sm font-medium text-red-600">{{ error }}</p>
        <button
          type="submit"
          class="w-full rounded-lg bg-indigo-600 px-4 py-2 font-medium text-white transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300"
        >
          Log in
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../api'

const router = useRouter()
const form = ref({ login: '', password: '' })
const error = ref('')

async function submit() {
  try {
    const { data } = await api.post('/login', form.value)
    localStorage.setItem('token', data.token)
    router.push('/results')
  } catch {
    error.value = 'Invalid credentials'
  }
}
</script>