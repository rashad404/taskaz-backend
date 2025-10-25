import api from './api';

export interface Category {
  id: number;
  name: string;
  slug: string;
  icon?: string;
  parent_id?: number | null;
  is_active: boolean;
  order: number;
  created_at?: string;
  updated_at?: string;
  parent?: Category;
  children?: Category[];
}

export interface CategoryFormData {
  name: string;
  slug?: string;
  icon?: string;
  parent_id?: number | null;
  is_active: boolean;
  order: number;
}

interface ApiResponse<T> {
  status: string;
  data: T;
  message?: string;
}

export const categoriesService = {
  async getAll(): Promise<Category[]> {
    const response = await api.get<ApiResponse<Category[]>>('/admin/categories');
    return response.data.data;
  },

  async getById(id: number): Promise<Category> {
    const response = await api.get<ApiResponse<Category>>(`/admin/categories/${id}`);
    return response.data.data;
  },

  async create(data: CategoryFormData): Promise<Category> {
    const response = await api.post<ApiResponse<Category>>('/admin/categories', data);
    return response.data.data;
  },

  async update(id: number, data: CategoryFormData): Promise<Category> {
    const response = await api.put<ApiResponse<Category>>(`/admin/categories/${id}`, data);
    return response.data.data;
  },

  async delete(id: number): Promise<void> {
    await api.delete(`/admin/categories/${id}`);
  },

  async reorder(orders: Array<{ id: number; order: number }>): Promise<void> {
    await api.post('/admin/categories/reorder', { orders });
  },
};