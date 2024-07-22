<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'surname',
        'otherNames',
        'dept',
        'employmentType',
        'employeeNo',
        'dateOfBirth',
        'sex',
        'religion',
        'telR',
        'telCell',
        'currentAddress',
        'residence',
        'postalAddress',
        'homeDistrict',
        'fatherName',
        'fatherDOB',
        'fatherOccupation',
        'motherName',
        'motherDOB',
        'motherOccupation',
        'maritalStatus',
        'spouseName',
        'dateOfMarriage',
        'spouseTel',
        'children',
        'siblings',
    ];

    /**
     * The user that the profile belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
