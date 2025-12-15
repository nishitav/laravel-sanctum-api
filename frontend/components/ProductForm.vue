<!-- components/ProductForm.vue -->
<template>
  <form @submit.prevent="submit">
    <div>
      <label for="name">Name</label>
      <input id="name" v-model="form.name" required />
    </div>

    <div>
      <label for="description">Description</label>
      <textarea id="description" v-model="form.description"></textarea>
    </div>

    <div>
      <label for="price">Price</label>
      <input id="price" type="number" step="0.01" v-model.number="form.price" required />
    </div>

    <div style="margin-top:8px;">
      <button type="submit">{{ submitLabel }}</button>
    </div>
  </form>
</template>

<script setup>
import { reactive, toRefs } from 'vue';

const props = defineProps({
  model: { type: Object, default: () => ({ name: '', description: '', price: 0 }) },
  submitLabel: { type: String, default: 'Save' }
});
const emits = defineEmits(['submit']);

const form = reactive({ ...props.model });

const submit = () => emits('submit', { ...form });
</script>
