<template>
  <div class="max-w-5xl mx-auto my-8 px-4 font-sans">
    <header class="mb-8">
      <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
        Financial Overview
      </h1>
      <p class="text-gray-500 mt-1">Track your balance, income, and expenses</p>
    </header>

    <div
      class="flex items-center p-6 bg-white rounded-xl shadow-sm border-l-4 border-green-500"
    >
      <div class="text-3xl mr-4">🔼</div>
      <div>
        <span
          class="text-xs font-semibold text-gray-400 uppercase tracking-wider"
          >Total Income</span
        >
        <h2 class="text-2xl font-bold text-gray-800 mt-0.5">
          ₱{{ (totalIncome || 0).toFixed(2) }}
        </h2>
      </div>
    </div>

    <div
      class="flex items-center p-6 bg-white rounded-xl shadow-sm border-l-4 border-red-500"
    >
      <div class="text-3xl mr-4">🔽</div>
      <div>
        <span
          class="text-xs font-semibold text-gray-400 uppercase tracking-wider"
          >Total Expenses</span
        >
        <h2 class="text-2xl font-bold text-gray-800 mt-0.5">
          ₱{{ (totalExpenses || 0).toFixed(2) }}
        </h2>
      </div>
    </div>

    <div
      class="flex items-center p-6 bg-white rounded-xl shadow-sm border-l-4"
      :class="netBalance < 0 ? 'border-rose-600' : 'border-blue-500'"
    >
      <div class="text-3xl mr-4">💰</div>
      <div>
        <span
          class="text-xs font-semibold text-gray-400 uppercase tracking-wider"
          >Net Balance</span
        >
        <h2
          class="text-2xl font-bold mt-0.5"
          :class="netBalance < 0 ? 'text-rose-600' : 'text-gray-800'"
        >
          ₱{{ (netBalance || 0).toFixed(2) }}
        </h2>
      </div>
    </div>

    <section class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
      <h3 class="text-xl font-bold text-gray-700 mb-4">Recent Activity</h3>
      <div v-if="loading" class="text-gray-400 py-4 text-center">
        Loading data...
      </div>
      <div
        v-else-if="transactions.length === 0"
        class="text-gray-400 py-4 text-center"
      >
        No transactions found.
      </div>

      <ul v-else class="divide-y divide-gray-100">
        <li
          v-for="item in transactions.slice(-5).reverse()"
          :key="item.id"
          class="flex justify-between items-center py-4"
        >
          <div>
            <span class="block font-semibold text-gray-800">{{
              item.title
            }}</span>
            <span class="text-xs text-gray-400"
              >{{ item.category }} • {{ item.transaction_date }}</span
            >
          </div>
          <span
            class="font-bold text-lg"
            :class="item.type === 'income' ? 'text-green-600' : 'text-red-500'"
          >
            {{ item.type === "income" ? "+" : "-" }}₱{{
              parseFloat(item.amount).toFixed(2)
            }}
          </span>
        </li>
      </ul>
    </section>
  </div>
</template>

<script setup>
import { onMounted } from "vue";
import { useTransactions } from "../composables/useTransactions";

const {
  transactions,
  loading,
  fetchTransactions,
  totalIncome,
  totalExpenses,
  netBalance,
} = useTransactions();

onMounted(() => {
  fetchTransactions();
});
</script>
