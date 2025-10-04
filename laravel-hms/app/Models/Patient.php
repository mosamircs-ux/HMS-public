<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * MIGRATION EXAMPLE: CodeIgniter Patient_model to Laravel Eloquent
 * 
 * CodeIgniter Pattern:
 * class Patient_model extends MY_Model {
 *     public function add($data) {
 *         $this->db->insert('patients', $data);
 *         return $this->db->insert_id();
 *     }
 *     public function get($id) {
 *         return $this->db->get_where('patients', ['id' => $id])->row();
 *     }
 * }
 * 
 * Laravel Pattern:
 * - Eloquent ORM with automatic CRUD operations
 * - Relationships defined as methods
 * - Scopes for query reusability
 * - Accessors/Mutators for data transformation
 */
class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'patients';
    
    protected $fillable = [
        'patient_unique_id',
        'admission_date',
        'patient_name',
        'age',
        'month',
        'gender',
        'blood_group',
        'marital_status',
        'phone',
        'email',
        'address',
        'guardian_name',
        'guardian_phone',
        'guardian_relation',
        'guardian_address',
        'patient_type',
        'organisation',
        'is_active',
    ];

    protected $casts = [
        'admission_date' => 'datetime',
        'age' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * CodeIgniter: Complex joins and queries
     * Laravel: Eloquent relationships
     * 
     * CodeIgniter (Original):
     * public function getPatientDetails($id) {
     *     $this->db->select('patients.*, opd_details.*');
     *     $this->db->from('patients');
     *     $this->db->join('opd_details', 'patients.id = opd_details.patient_id');
     *     $this->db->where('patients.id', $id);
     *     return $this->db->get()->row();
     * }
     * 
     * Laravel (Converted):
     */
    public function opdDetails()
    {
        return $this->hasMany(OpdDetail::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function ipdDetails()
    {
        return $this->hasMany(IpdDetail::class);
    }

    /**
     * CodeIgniter: Manual query for active patients
     * $this->db->where('is_active', 'yes')->get('patients')->result();
     * 
     * Laravel: Query scope
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * CodeIgniter: Custom getter method
     * public function getFullDetails($id) {
     *     return $this->db->get_where('patients', ['id' => $id])->row();
     * }
     * 
     * Laravel: Accessor
     */
    public function getFullNameAttribute()
    {
        return "{$this->patient_name} ({$this->patient_unique_id})";
    }

    /**
     * Usage Examples:
     * 
     * CodeIgniter:
     * $patient = $this->patient_model->add($data);
     * $patient = $this->patient_model->get($id);
     * $this->patient_model->update($id, $data);
     * 
     * Laravel:
     * $patient = Patient::create($data);
     * $patient = Patient::find($id);
     * $patient = Patient::where('email', $email)->first();
     * $patient->update($data);
     * $activePatients = Patient::active()->get();
     * $patientWithAppointments = Patient::with('appointments')->find($id);
     */
}
