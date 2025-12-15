<!-- pages/products/[id].vue -->
<template>
  <div style="padding:24px;">
    <div v-if="loading">Loading...</div>

    <div v-else>
      <div v-if="editing">
        <h2>Edit Product</h2>
        <ProductForm :model="product" submitLabel="Update" @submit="update" />
      </div>

      <div v-else>
        <h2>{{ product.name }}</h2>
        <p>{{ product.description }}</p>
        <p>Price: ₹{{ product.price }}</p>
        <div>
          <button v-if="canUpdate" @click="editing = true">Edit</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import ProductForm from '~/components/ProductForm.vue';
import { ref, computed } from 'vue';

const route = useRoute();
const id = route.params.id;
const product = ref(null);
const loading = ref(true);
const editing = ref(false);
const { $api } = useNuxtApp();
const { hasAbility } = useAuth();
const canUpdate = computed(() => hasAbility('products:update'));

const fetchProduct = async () => {
  loading.value = true;
  try {
    product.value = await $api(`/products/${id}`);
  } catch (e) {
    if (e?.status === 401) navigateTo('/login');
    product.value = null;
  } finally {
    loading.value = false;
  }
};

onMounted(fetchProduct);

const update = async (payload) => {
  try {
    await $api(`/products/${id}`, { method: 'PUT', body: payload });
    editing.value = false;
    await fetchProduct();
  } catch (e) {
    alert(e?.data?.message || 'Update failed');
  }
};
</script>