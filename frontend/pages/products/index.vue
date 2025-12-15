<!-- pages/products/index.vue -->
<template>
  <div style="padding:24px;">
    <h1>Products</h1>

    <div style="margin:12px 0;">
      <NuxtLink to="/products/create" v-if="canCreate">Create Product</NuxtLink>
    </div>

    <div v-if="loading">Loading...</div>

    <ul v-else>
      <li v-for="p in products" :key="p.id" style="margin:8px 0;">
        <NuxtLink :to="`/products/${p.id}`">{{ p.name }}</NuxtLink>
        <span> — ₹{{ p.price }}</span>

        <button v-if="canUpdate" @click="goEdit(p.id)" style="margin-left:8px;">Edit</button>
        <button v-if="canDelete" @click="remove(p.id)" style="margin-left:6px;color:red;">Delete</button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
const products = ref([]);
const loading = ref(true);
const { $api } = useNuxtApp();
const { hasAbility } = useAuth();

const canCreate = computed(() => hasAbility('products:create'));
const canUpdate = computed(() => hasAbility('products:update'));
const canDelete = computed(() => hasAbility('products:delete'));

const fetchProducts = async () => {
  loading.value = true;
  try {
    products.value = await $api('/products');
  } catch (e) {
    // handle errors (401/403)
    if (e?.status === 401) navigateTo('/login');
    products.value = [];
  } finally {
    loading.value = false;
  }
};

onMounted(fetchProducts);

const goEdit = (id) => navigateTo(`/products/${id}`);
const remove = async (id) => {
  if (!confirm('Delete product?')) return;
  try {
    await $api(`/products/${id}`, { method: 'DELETE' });
    await fetchProducts();
  } catch (e) {
    alert(e?.data?.message || 'Delete failed');
  }
};
</script>