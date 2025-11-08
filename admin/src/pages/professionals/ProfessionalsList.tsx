import { useState, useEffect } from 'react';
import { CheckCircle, XCircle, Clock, User, Mail, MapPin, DollarSign, Briefcase, Eye, Edit } from 'lucide-react';
import { professionalsService, Professional } from '../../services/professionals';
import toast from 'react-hot-toast';

const ProfessionalsList = () => {
  const [professionals, setProfessionals] = useState<Professional[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [statusFilter, setStatusFilter] = useState<string>('');
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedProfessional, setSelectedProfessional] = useState<Professional | null>(null);
  const [rejectReason, setRejectReason] = useState('');
  const [revokeReason, setRevokeReason] = useState('');
  const [actionLoading, setActionLoading] = useState<number | null>(null);

  useEffect(() => {
    fetchProfessionals();
  }, [statusFilter, searchTerm]);

  const fetchProfessionals = async () => {
    try {
      setLoading(true);
      const data = await professionalsService.getAll({
        status: statusFilter || undefined,
        search: searchTerm || undefined,
      });
      setProfessionals(data.data);
      setError(null);
    } catch (err) {
      setError('Failed to fetch professionals');
      console.error('Error fetching professionals:', err);
    } finally {
      setLoading(false);
    }
  };

  const handleApprove = async (id: number) => {
    if (!window.confirm('Are you sure you want to approve this professional?')) {
      return;
    }

    try {
      setActionLoading(id);
      await professionalsService.approve(id);
      toast.success('Professional approved successfully!');
      await fetchProfessionals();
    } catch (err) {
      console.error('Error approving professional:', err);
      toast.error('Failed to approve professional');
    } finally {
      setActionLoading(null);
    }
  };

  const handleReject = async (id: number) => {
    if (!rejectReason.trim()) {
      toast.error('Please provide a reason for rejection');
      return;
    }

    try {
      setActionLoading(id);
      await professionalsService.reject(id, rejectReason);
      toast.success('Professional rejected');
      setSelectedProfessional(null);
      setRejectReason('');
      await fetchProfessionals();
    } catch (err) {
      console.error('Error rejecting professional:', err);
      toast.error('Failed to reject professional');
    } finally {
      setActionLoading(null);
    }
  };

  const handleRevoke = async (id: number) => {
    if (!revokeReason.trim()) {
      toast.error('Please provide a reason for revoking');
      return;
    }

    try {
      setActionLoading(id);
      await professionalsService.revoke(id, revokeReason);
      toast.success('Professional status revoked');
      setSelectedProfessional(null);
      setRevokeReason('');
      await fetchProfessionals();
    } catch (err) {
      console.error('Error revoking professional:', err);
      toast.error('Failed to revoke professional');
    } finally {
      setActionLoading(null);
    }
  };

  const getStatusBadge = (status: string) => {
    switch (status) {
      case 'approved':
        return 'bg-green-100 text-green-800';
      case 'rejected':
        return 'bg-red-100 text-red-800';
      case 'pending':
        return 'bg-yellow-100 text-yellow-800';
      default:
        return 'bg-gray-100 text-gray-800';
    }
  };

  const getStatusIcon = (status: string) => {
    switch (status) {
      case 'approved':
        return <CheckCircle className="h-4 w-4 text-green-600" />;
      case 'rejected':
        return <XCircle className="h-4 w-4 text-red-600" />;
      case 'pending':
        return <Clock className="h-4 w-4 text-yellow-600" />;
      default:
        return null;
    }
  };

  if (loading) {
    return (
      <div className="flex justify-center items-center h-64">
        <div className="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        {error}
      </div>
    );
  }

  return (
    <div className="px-4 sm:px-6 lg:px-8">
      {/* Header */}
      <div className="mb-6">
        <h1 className="text-2xl font-bold text-gray-900">Professional Applications</h1>
        <p className="text-gray-600 mt-1">Review and manage professional applications</p>
      </div>

      {/* Filters */}
      <div className="mb-6 flex flex-col sm:flex-row gap-4">
        {/* Status Filter */}
        <div>
          <label className="block text-sm font-medium text-gray-700 mb-1">Status</label>
          <select
            value={statusFilter}
            onChange={(e) => setStatusFilter(e.target.value)}
            className="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option value="">All</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
          </select>
        </div>

        {/* Search */}
        <div className="flex-1">
          <label className="block text-sm font-medium text-gray-700 mb-1">Search</label>
          <input
            type="text"
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
            placeholder="Search by name or email..."
            className="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>
      </div>

      {/* Count */}
      <div className="mb-4">
        <p className="text-sm text-gray-600">
          Showing {professionals.length} professional{professionals.length !== 1 ? 's' : ''}
        </p>
      </div>

      {/* List */}
      <div className="space-y-4">
        {professionals.length === 0 ? (
          <div className="text-center py-12 bg-gray-50 rounded-lg">
            <p className="text-gray-500">No professionals found</p>
          </div>
        ) : (
          professionals.map((professional) => (
            <div key={professional.id} className="bg-white rounded-lg shadow p-6">
              <div className="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                {/* Left Section - User Info */}
                <div className="flex-1">
                  <div className="flex items-start justify-between mb-3">
                    <div>
                      <h3 className="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <User className="h-5 w-5 text-gray-400" />
                        {professional.name}
                      </h3>
                      <div className="flex items-center gap-2 mt-1">
                        <Mail className="h-4 w-4 text-gray-400" />
                        <span className="text-sm text-gray-600">{professional.email}</span>
                      </div>
                    </div>
                    <div className={`px-3 py-1 rounded-full text-xs font-medium flex items-center gap-1 ${getStatusBadge(professional.professional_status)}`}>
                      {getStatusIcon(professional.professional_status)}
                      <span className="capitalize">{professional.professional_status}</span>
                    </div>
                  </div>

                  {/* Professional Details */}
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4">
                    <div className="flex items-center gap-2 text-sm">
                      <MapPin className="h-4 w-4 text-gray-400" />
                      <span className="text-gray-700">{professional.location}</span>
                    </div>
                    <div className="flex items-center gap-2 text-sm">
                      <DollarSign className="h-4 w-4 text-gray-400" />
                      <span className="text-gray-700">{professional.hourly_rate} AZN/hour</span>
                    </div>
                    <div className="flex items-start gap-2 text-sm md:col-span-2">
                      <Briefcase className="h-4 w-4 text-gray-400 mt-0.5" />
                      <div className="flex flex-wrap gap-1">
                        {professional.skills.slice(0, 5).map((skill, index) => (
                          <span key={index} className="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-xs">
                            {skill}
                          </span>
                        ))}
                        {professional.skills.length > 5 && (
                          <span className="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-xs">
                            +{professional.skills.length - 5} more
                          </span>
                        )}
                      </div>
                    </div>
                  </div>

                  {/* Bio */}
                  <div className="mt-4 flex items-center gap-3">
                    <button
                      onClick={() => setSelectedProfessional(selectedProfessional?.id === professional.id ? null : professional)}
                      className="text-sm text-blue-600 hover:text-blue-700 flex items-center gap-1"
                    >
                      <Eye className="h-4 w-4" />
                      {selectedProfessional?.id === professional.id ? 'Hide Details' : 'View Details'}
                    </button>
                    <a
                      href={`${import.meta.env.VITE_FRONTEND_URL || 'http://100.89.150.50:3008'}/professionals/${professional.slug}`}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="text-sm text-indigo-600 hover:text-indigo-700 flex items-center gap-1"
                    >
                      <Edit className="h-4 w-4" />
                      View Profile
                    </a>
                  </div>
                </div>

                {/* Right Section - Actions */}
                {professional.professional_status === 'pending' && (
                  <div className="flex lg:flex-col gap-2">
                    <button
                      onClick={() => handleApprove(professional.id)}
                      disabled={actionLoading === professional.id}
                      className="flex-1 lg:flex-none px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                    >
                      <CheckCircle className="h-4 w-4" />
                      Approve
                    </button>
                    <button
                      onClick={() => {
                        setSelectedProfessional(professional);
                        setRejectReason('');
                      }}
                      disabled={actionLoading === professional.id}
                      className="flex-1 lg:flex-none px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                    >
                      <XCircle className="h-4 w-4" />
                      Reject
                    </button>
                  </div>
                )}
                {professional.professional_status === 'approved' && (
                  <div className="flex lg:flex-col gap-2">
                    <button
                      onClick={() => {
                        setSelectedProfessional(professional);
                        setRevokeReason('');
                      }}
                      disabled={actionLoading === professional.id}
                      className="flex-1 lg:flex-none px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                    >
                      <XCircle className="h-4 w-4" />
                      Revoke
                    </button>
                  </div>
                )}
              </div>

              {/* Expanded Details */}
              {selectedProfessional?.id === professional.id && (
                <div className="mt-4 pt-4 border-t border-gray-200">
                  <h4 className="font-semibold text-gray-900 mb-2">Bio:</h4>
                  <div
                    className="prose prose-sm max-w-none text-gray-700"
                    dangerouslySetInnerHTML={{ __html: professional.bio }}
                  />

                  {professional.portfolio_items && professional.portfolio_items.length > 0 && (
                    <div className="mt-4">
                      <h4 className="font-semibold text-gray-900 mb-2">Portfolio ({professional.portfolio_items.length}):</h4>
                      <div className="space-y-2">
                        {professional.portfolio_items.map((item, index) => (
                          <div key={index} className="p-3 bg-gray-50 rounded-md">
                            <p className="font-medium text-gray-900">{item.title}</p>
                            {item.description && <p className="text-sm text-gray-600 mt-1">{item.description}</p>}
                            {item.project_url && (
                              <a href={item.project_url} target="_blank" rel="noopener noreferrer" className="text-sm text-blue-600 hover:underline mt-1 inline-block">
                                View Project →
                              </a>
                            )}
                          </div>
                        ))}
                      </div>
                    </div>
                  )}

                  {professional.professional_status === 'rejected' && professional.professional_rejected_reason && (
                    <div className="mt-4 p-3 bg-red-50 rounded-md">
                      <h4 className="font-semibold text-red-900 mb-1">Rejection Reason:</h4>
                      <p className="text-sm text-red-700">{professional.professional_rejected_reason}</p>
                    </div>
                  )}

                  {professional.professional_status === 'pending' && (
                    <div className="mt-4 p-4 bg-gray-50 rounded-md">
                      <label className="block text-sm font-medium text-gray-700 mb-2">
                        Rejection Reason (required)
                      </label>
                      <textarea
                        value={rejectReason}
                        onChange={(e) => setRejectReason(e.target.value)}
                        placeholder="Provide a reason for rejection..."
                        rows={3}
                        className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                      />
                      <button
                        onClick={() => handleReject(professional.id)}
                        disabled={!rejectReason.trim() || actionLoading === professional.id}
                        className="mt-2 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                      >
                        {actionLoading === professional.id ? 'Rejecting...' : 'Confirm Rejection'}
                      </button>
                    </div>
                  )}

                  {professional.professional_status === 'approved' && (
                    <div className="mt-4 p-4 bg-orange-50 rounded-md">
                      <label className="block text-sm font-medium text-gray-700 mb-2">
                        Revoke Reason (required)
                      </label>
                      <textarea
                        value={revokeReason}
                        onChange={(e) => setRevokeReason(e.target.value)}
                        placeholder="Provide a reason for revoking professional status..."
                        rows={3}
                        className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                      />
                      <button
                        onClick={() => handleRevoke(professional.id)}
                        disabled={!revokeReason.trim() || actionLoading === professional.id}
                        className="mt-2 px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                      >
                        {actionLoading === professional.id ? 'Revoking...' : 'Confirm Revoke'}
                      </button>
                    </div>
                  )}
                </div>
              )}
            </div>
          ))
        )}
      </div>
    </div>
  );
};

export default ProfessionalsList;
