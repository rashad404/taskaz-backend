import api from './api';

export interface Professional {
  id: number;
  name: string;
  email: string;
  bio: string;
  location: string;
  city_id: number;
  district_id?: number;
  settlement_id?: number;
  metro_station_id?: number;
  skills: string[];
  hourly_rate: number;
  portfolio_items?: Array<{
    title: string;
    description?: string;
    image_url?: string;
    project_url?: string;
  }>;
  professional_status: 'pending' | 'approved' | 'rejected';
  professional_application_date: string;
  professional_approved_at?: string;
  professional_rejected_reason?: string;
}

export interface ProfessionalsListResponse {
  data: Professional[];
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
}

export const professionalsService = {
  async getAll(params?: { status?: string; search?: string; page?: number }): Promise<ProfessionalsListResponse> {
    const response = await api.get('/admin/professionals', { params });
    return response.data;
  },

  async getById(id: number): Promise<Professional> {
    const response = await api.get(`/admin/professionals/${id}`);
    return response.data.data;
  },

  async approve(id: number): Promise<{ message: string; data: Professional }> {
    const response = await api.post(`/admin/professionals/${id}/approve`);
    return response.data;
  },

  async reject(id: number, reason: string): Promise<{ message: string; data: Professional }> {
    const response = await api.post(`/admin/professionals/${id}/reject`, { reason });
    return response.data;
  },

  async revoke(id: number, reason: string): Promise<{ message: string; data: Professional }> {
    const response = await api.post(`/admin/professionals/${id}/revoke`, { reason });
    return response.data;
  },
};
