// types/api.d.ts
export interface User {
  id: number;
  name: string;
  email: string;
  // add other fields you return from /auth/me
}

export interface LoginResponse {
  token: string;
  user: User;
  abilities?: string[];
}

export interface Product {
  id: number;
  name: string;
  description?: string | null;
  price: number;
  created_at?: string;
  updated_at?: string;
}
