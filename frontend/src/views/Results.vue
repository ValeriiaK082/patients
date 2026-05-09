<template>
  <div class="min-h-screen bg-slate-50 p-6">
    <div v-if="data" class="mx-auto max-w-5xl space-y-6">
      <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-semibold text-slate-900">
          {{ data.patient.name }} {{ data.patient.surname }}
        </h1>
        <p class="mt-2 text-sm text-slate-600">
          Sex: {{ data.patient.sex }} · Born: {{ data.patient.birthDate }}
        </p>
      </div>

      <div
        v-for="order in data.orders"
        :key="order.orderId"
        class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm"
      >
        <h2 class="mb-4 text-lg font-semibold text-slate-900">Order #{{ order.orderId }}</h2>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-100">
              <tr>
                <th class="px-4 py-3 text-left font-semibold text-slate-700">Test</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-700">Value</th>
                <th class="px-4 py-3 text-left font-semibold text-slate-700">Reference</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
              <tr v-for="r in order.results" :key="r.name" class="hover:bg-slate-50">
                <td class="px-4 py-3 text-slate-700">{{ r.name }}</td>
                <td class="px-4 py-3 font-medium text-slate-900">{{ r.value }}</td>
                <td class="px-4 py-3 text-slate-600">{{ r.reference }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <button
        @click="logout"
        class="rounded-lg bg-slate-900 px-4 py-2 font-medium text-white transition hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-300"
      >
        Log out
      </button>
    </div>
    <p v-else class="text-center text-slate-600">Loading...</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '../api'

const data = ref(null)
const router = useRouter()

onMounted(async () => {
  const res = await api.get('/results')
  data.value = res.data
})

function logout() {
  localStorage.removeItem('token')
  router.push('/')
}
</script>