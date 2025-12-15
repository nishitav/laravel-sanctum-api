// composables/useAuth.js
export const useAuth = () => {
  const authToken = useState('authToken', () => useCookie('auth_token').value || null);
  const user = useState('authUser', () => null);
  const abilities = useState('authAbilities', () => []);
  const { $api } = useNuxtApp();

  const login = async (email, password) => {
    const res = await $api('/auth/login', { method: 'POST', body: { email, password } });
    // res: { token, user, abilities }
    authToken.value = res.token;
    useCookie('auth_token').value = res.token;
    user.value = res.user;
    abilities.value = res.abilities || [];
    return res;
  };

  const fetchMe = async () => {
    if (!authToken.value) return null;
    try {
      const me = await $api('/auth/me');
      user.value = me;
      return me;
    } catch (err) {
      // token invalid/expired
      authToken.value = null;
      useCookie('auth_token').value = null;
      user.value = null;
      abilities.value = [];
      throw err;
    }
  };

  const logout = async () => {
    try {
      await $api('/auth/logout', { method: 'POST' });
    } catch (e) {
      // ignore errors
    }
    authToken.value = null;
    useCookie('auth_token').value = null;
    user.value = null;
    abilities.value = [];
  };

  const hasAbility = (ability) => {
    if (!abilities.value) return false;
    if (abilities.value.includes('*')) return true;
    return abilities.value.includes(ability);
  };

  return { authToken, user, abilities, login, fetchMe, logout, hasAbility };
};
