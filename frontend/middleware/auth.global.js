// middleware/auth.global.js
export default defineNuxtRouteMiddleware(async (to) => {
  const { authToken, fetchMe } = useAuth();

  // allow open routes
  if (to.path === '/login') return;

  if (!authToken.value) return navigateTo('/login');

  // ensure user loaded
  if (!useState('authUser').value) {
    try {
      await fetchMe();
    } catch {
      return navigateTo('/login');
    }
  }
});
