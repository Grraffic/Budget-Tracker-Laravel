<template>
  <div class="max-w-5xl mx-auto my-8 px-4 font-sans">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 tracking-tight">
      Manage Transactions
    </h2>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
      <h3
        class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4"
      >
        Add New Transaction
      </h3>
      <form
        @submit.prevent="submitTransactionForm"
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3"
      >
        <input
          v-model="form.title"
          type="text"
          placeholder="Title"
          required
          class="p-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        />

        <input
          v-model.number="form.amount"
          type="number"
          step="0.01"
          placeholder="Amount (₱)"
          required
          class="p-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        />

        <select
          v-model="form.type"
          required
          class="p-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          <option value="" disabled>Select Type</option>
          <option value="income">Income</option>
          <option value="expense">Expense</option>
        </select>

        <input
          v-model="form.category"
          type="text"
          placeholder="Category (e.g., Food)"
          required
          class="p-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        />

        <input
          v-model="form.transaction_date"
          type="date"
          required
          class="p-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        />

        <button
          type="submit"
          class="bg-blue-500 hover:bg-blue-600 text-white font-semibold text-sm rounded-lg p-2.5 transition duration-200 shadow-sm"
        >
          Add Record
        </button>
      </form>
    </div>

    <div
      class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden"
    >
      <div v-if="loading" class="p-8 text-center text-gray-400">
        Loading database records...
      </div>

      <table v-else class="w-full border-collapse text-left text-sm">
        <thead>
          <tr
            class="bg-gray-800 text-white text-xs font-semibold uppercase tracking-wider"
          >
            <th class="p-4">Date</th>
            <th class="p-4">Title</th>
            <th class="p-4">Category</th>
            <th class="p-4">Type</th>
            <th class="p-4">Amount</th>
            <th class="p-4 text-center">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-gray-600">
          <tr
            v-for="item in transactions"
            :key="item.id"
            class="hover:bg-gray-50 transition duration-150"
          >
            <td class="p-4 whitespace-nowrap">{{ item.transaction_date }}</td>
            <td class="p-4 font-medium text-gray-900">{{ item.title }}</td>
            <td class="p-4">
              <span
                class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs"
                >{{ item.category }}</span
              >
            </td>
            <td class="p-4">
              <span
                class="px-2 py-1 rounded text-xs font-bold uppercase tracking-wide"
                :class="
                  item.type === 'income'
                    ? 'bg-green-100 text-green-800'
                    : 'bg-red-100 text-red-800'
                "
              >
                {{ item.type }}
              </span>
            </td>
            <td
              class="p-4 font-bold text-base"
              :class="
                item.type === 'income' ? 'text-green-600' : 'text-red-500'
              "
            >
              ₱{{ parseFloat(item.amount).toFixed(2) }}
            </td>
            <td class="p-4 text-center">
              <button
                @click="deleteTransaction(item.id)"
                class="border border-red-200 text-red-500 hover:bg-red-50 px-3 py-1.5 rounded-md text-xs font-medium transition duration-150"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useTransactions } from "../composables/useTransactions";

const {
  transactions,
  loading,
  form,
  fetchTransactions,
  submitTransactionForm,
  deleteTransaction,
} = useTransactions();



onMounted(() => {
  fetchTransactions();
});
</script>
