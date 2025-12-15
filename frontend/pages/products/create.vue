<!-- pages/products/create.vue -->
<template>
  <div style="padding:24px;">
    <h1>Create Product</h1>
    <ProductForm @submit="create" />
  </div>
</template>

<script setup>
import ProductForm from '~/components/ProductForm.vue';
const { $api } = useNuxtApp();
const router = useRouter();

const create = async (payload) => {
  try {
    await $api('/products', { method: 'POST', body: payload });
    router.push('/products');
  } catch (e) {
    alert(e?.data?.message || 'Create failed');
  }
};
</script>