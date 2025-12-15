<!-- pages/login.vue -->
<template>
  <div style="max-width:480px;margin:40px auto;">
    <h1>Login</h1>
    <form @submit.prevent="doLogin">
      <div><input v-model="email" placeholder="Email" required /></div>
      <div style="margin-top:8px;"><input type="password" v-model="password" placeholder="Password" required /></div>
      <div style="margin-top:12px;">
        <button :disabled="loading">{{ loading ? 'Logging...' : 'Login' }}</button>
      </div>
      <p v-if="error" style="color:red;margin-top:8px;">{{ error }}</p>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
const email = ref('demo@example.com');
const password = ref('secret');
const loading = ref(false);
const error = ref(null);
const router = useRouter();
const { login } = useAuth();

const doLogin = async () => {
  loading.value = true;
  error.value = null;
  try {
    await login(email.value, password.value);
    await router.push('/dashboard');
  } catch (e) {
    error.value = e?.data?.message || 'Login failed';
  } finally {
    loading.value = false;
  }
};
</script>
