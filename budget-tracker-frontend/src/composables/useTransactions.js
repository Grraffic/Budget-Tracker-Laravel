import { ref, computed } from "vue";
import api from "../services/api";

const transactions = ref([]);
const loading = ref(false);

const form = ref({
  title: '',
  amount: '',
  type: '',
  category: '',
  transaction_date: ''
})

export function useTransactions() {
  // Read all Transactions
  const fetchTransactions = async () => {
    if (transactions.value.length > 0) return;
    loading.value = true;

    try {
      const response = await api.get("/transaction");
      transactions.value = response.data.data;
    } catch (error) {
      console.error(error);
    } finally {
      loading.value = false;
    }
  };

  // Create Transactions
  const addTransaction = async (formData) => {
    try {
      const response = await api.post("/transaction", formData);
      transactions.value.push(response.data.data);
      return { success: true };
    } catch (error) {
      console.error("Failed to add transactions", error);
      return { success: false };
    }
  };

  const submitTransactionForm = async () => {
    const result = await addTransaction(form.value);
    if(result.success) {
      form.value = {
        title: '',
        amount: '',
        type: '',
        category: '',
        transaction_date: ''
      };
    }
  };

  // Update Transactions
  const updateTransaction = async (id, updateData) => {
    try {
      const response = await api.put(`/transaction/${id}`, updateData);

      const index = transactions.value.findIndex((item) => item.id === id);
      if (index !== -1) {
        transactions.value[index] = response.data.data;
      }
    } catch (error) {
      console.error("Failed to update transaction data.", error);
    }
  };

  const deleteTransaction = async (id) => {
    try {
      await api.delete(`/transaction/${id}`);
      transactions.value = transactions.value.filter((item) => item.id !== id);
    } catch (error) {
      console.error("Failed Deleting transaction", error);
    }
  };

  // Computed Metrics for Dashboards
  const totalIncome = computed(() => {
    return (
      transactions.value
        // FIX: Added 'item &&' to verify the item exists before reading its .type property
        .filter((item) => item && item.type === "income")
        .reduce((sum, item) => sum + parseFloat(item.amount || 0), 0)
    );
  });

  const totalExpenses = computed(() => {
    return (
      transactions.value
        // FIX: Added 'item &&' to verify the item exists before reading its .type property
        .filter((item) => item && item.type === "expense")
        .reduce((sum, item) => sum + parseFloat(item.amount || 0), 0)
    );
  });

  const netBalance = computed(() => totalIncome.value - totalExpenses.value);

  return {
    transactions,
    loading,
    form,
    fetchTransactions,
    addTransaction,
    submitTransactionForm,
    updateTransaction,
    deleteTransaction,
    totalIncome,
    totalExpenses,
    netBalance,
  };
}
