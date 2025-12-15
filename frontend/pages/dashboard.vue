<!-- pages/dashboard.vue -->
<template>
  <div style="padding:24px;">
    <h1>Dashboard</h1>
    <p v-if="user">Welcome, <strong>{{ user.name }}</strong></p>

    <nav style="margin:12px 0;">
      <NuxtLink to="/products">Products</NuxtLink>
      <button @click="doLogout" style="margin-left:12px;">Logout</button>
    </nav>
  </div>
</template>

<script setup>
const { user, fetchMe, logout } = useAuth();
onMounted(async () => { try { await fetchMe(); } catch (e) { /* ignore */ }});
const doLogout = async () => { await logout(); navigateTo('/login'); };
</script>
