// plugins/api.client.js
export default defineNuxtPlugin((nuxtApp) => {
  const config = useRuntimeConfig();

  const api = $fetch.create({
    baseURL: `${config.public.apiBase}/api`,
    async onRequest({ options }) {
      // read token from cookie (httpOnly tokens won't be readable; this demo uses JS cookie)
      const token = useCookie('auth_token').value || null;
      if (token) {
        options.headers = options.headers || {};
        options.headers.Authorization = `Bearer ${token}`;
      }
    },
    async onResponseError({ response }) {
      // If unauthorized, allow the client to handle (401) — we won't auto-redirect here
      return Promise.reject(response);
    }
  });

  // expose as $api
  return {
    provide: {
      api
    }
  };
});
