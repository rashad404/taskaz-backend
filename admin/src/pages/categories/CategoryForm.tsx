import { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import { ArrowLeft, Save } from 'lucide-react';
import { categoriesService, Category, CategoryFormData } from '../../services/categories';
import toast from 'react-hot-toast';

const CategoryForm = () => {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const isEdit = Boolean(id);

  const [loading, setLoading] = useState(false);
  const [saving, setSaving] = useState(false);
  const [categories, setCategories] = useState<Category[]>([]);
  const [formData, setFormData] = useState<CategoryFormData>({
    name: '',
    slug: '',
    icon: '',
    parent_id: null,
    is_active: true,
    order: 0,
  });

  useEffect(() => {
    fetchCategories();
    if (isEdit && id) {
      fetchCategory(parseInt(id));
    } else {
      // Set default order for new category
      setDefaultOrder();
    }
  }, [id]);

  const fetchCategories = async () => {
    try {
      const data = await categoriesService.getAll();
      setCategories(data);
    } catch (err) {
      console.error('Error fetching categories:', err);
    }
  };

  const fetchCategory = async (categoryId: number) => {
    try {
      setLoading(true);
      const category = await categoriesService.getById(categoryId);
      setFormData({
        name: category.name,
        slug: category.slug,
        icon: category.icon || '',
        parent_id: category.parent_id || null,
        is_active: category.is_active,
        order: category.order,
      });
    } catch (err) {
      console.error('Error fetching category:', err);
      toast.error('Failed to load category');
      navigate('/categories');
    } finally {
      setLoading(false);
    }
  };

  const setDefaultOrder = async () => {
    try {
      const allCategories = await categoriesService.getAll();
      const maxOrder = Math.max(...allCategories.map(c => c.order), 0);
      setFormData(prev => ({ ...prev, order: maxOrder + 1 }));
    } catch (err) {
      console.error('Error setting default order:', err);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    if (!formData.name.trim()) {
      toast.error('Category name is required');
      return;
    }

    try {
      setSaving(true);
      if (isEdit && id) {
        await categoriesService.update(parseInt(id), formData);
        toast.success('Category updated successfully!');
      } else {
        await categoriesService.create(formData);
        toast.success('Category created successfully!');
      }
      navigate('/categories');
    } catch (err: any) {
      console.error('Error saving category:', err);
      const message = err?.response?.data?.message || 'Failed to save category';
      toast.error(message);
    } finally {
      setSaving(false);
    }
  };

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
    const { name, value, type } = e.target;

    if (type === 'checkbox') {
      const checked = (e.target as HTMLInputElement).checked;
      setFormData(prev => ({ ...prev, [name]: checked }));
    } else if (name === 'parent_id') {
      setFormData(prev => ({
        ...prev,
        [name]: value === '' ? null : parseInt(value)
      }));
    } else if (name === 'order') {
      setFormData(prev => ({
        ...prev,
        [name]: parseInt(value) || 0
      }));
    } else {
      setFormData(prev => ({ ...prev, [name]: value }));
    }
  };

  if (loading) {
    return (
      <div className="flex items-center justify-center h-64">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
      </div>
    );
  }

  // Filter out current category from parent options (can't be its own parent)
  const parentOptions = categories.filter(c => !isEdit || c.id !== parseInt(id || '0'));

  return (
    <div>
      <div className="mb-6">
        <button
          onClick={() => navigate('/categories')}
          className="inline-flex items-center text-gray-600 hover:text-gray-900"
        >
          <ArrowLeft className="w-4 h-4 mr-2" />
          Back to Categories
        </button>
      </div>

      <div className="bg-white rounded-lg shadow p-6">
        <h1 className="text-2xl font-bold text-gray-900 mb-6">
          {isEdit ? 'Edit Category' : 'Add New Category'}
        </h1>

        <form onSubmit={handleSubmit} className="space-y-6">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {/* Name */}
            <div>
              <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-2">
                Category Name <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                id="name"
                name="name"
                value={formData.name}
                onChange={handleChange}
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                required
              />
            </div>

            {/* Slug */}
            <div>
              <label htmlFor="slug" className="block text-sm font-medium text-gray-700 mb-2">
                Slug (optional)
              </label>
              <input
                type="text"
                id="slug"
                name="slug"
                value={formData.slug}
                onChange={handleChange}
                placeholder="Auto-generated from name if empty"
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              />
              <p className="mt-1 text-xs text-gray-500">Leave empty to auto-generate from name</p>
            </div>

            {/* Icon */}
            <div>
              <label htmlFor="icon" className="block text-sm font-medium text-gray-700 mb-2">
                Icon (Lucide icon name)
              </label>
              <input
                type="text"
                id="icon"
                name="icon"
                value={formData.icon}
                onChange={handleChange}
                placeholder="e.g., Wrench, Code, BookOpen"
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              />
              <p className="mt-1 text-xs text-gray-500">
                Find icons at <a href="https://lucide.dev/icons" target="_blank" rel="noopener noreferrer" className="text-indigo-600 hover:underline">lucide.dev</a>
              </p>
            </div>

            {/* Parent Category */}
            <div>
              <label htmlFor="parent_id" className="block text-sm font-medium text-gray-700 mb-2">
                Parent Category
              </label>
              <select
                id="parent_id"
                name="parent_id"
                value={formData.parent_id || ''}
                onChange={handleChange}
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
              >
                <option value="">None (Top Level)</option>
                {parentOptions
                  .filter(c => !c.parent_id) // Only show top-level categories as parent options
                  .map(category => (
                    <option key={category.id} value={category.id}>
                      {category.name}
                    </option>
                  ))}
              </select>
              <p className="mt-1 text-xs text-gray-500">Select a parent to make this a subcategory</p>
            </div>

            {/* Order */}
            <div>
              <label htmlFor="order" className="block text-sm font-medium text-gray-700 mb-2">
                Order <span className="text-red-500">*</span>
              </label>
              <input
                type="number"
                id="order"
                name="order"
                value={formData.order}
                onChange={handleChange}
                min="0"
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                required
              />
              <p className="mt-1 text-xs text-gray-500">Lower numbers appear first</p>
            </div>

            {/* Active Status */}
            <div className="flex items-center">
              <input
                type="checkbox"
                id="is_active"
                name="is_active"
                checked={formData.is_active}
                onChange={handleChange}
                className="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
              />
              <label htmlFor="is_active" className="ml-2 block text-sm text-gray-700">
                Active (visible on website)
              </label>
            </div>
          </div>

          {/* Submit Buttons */}
          <div className="flex justify-end space-x-4 pt-6 border-t">
            <button
              type="button"
              onClick={() => navigate('/categories')}
              className="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors"
              disabled={saving}
            >
              Cancel
            </button>
            <button
              type="submit"
              disabled={saving}
              className="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <Save className="w-4 h-4 mr-2" />
              {saving ? 'Saving...' : isEdit ? 'Update Category' : 'Create Category'}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default CategoryForm;
