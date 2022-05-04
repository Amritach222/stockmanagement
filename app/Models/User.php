<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $guard_name = 'api';

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'user_id');
    }

    public function logs()
    {
        return $this->hasMany(Log::class, 'user_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'user_id');
    }

    public function budgetRequestApproves()
    {
        return $this->hasMany(BudgetRequest::class, 'approved_by');
    }

    public function budgetRequests()
    {
        return $this->hasMany(BudgetRequest::class, 'user_id');
    }

    public function consumes()
    {
        return $this->hasMany(Consume::class, 'user_id');
    }

    public function approvedConsumes()
    {
        return $this->hasMany(Consume::class, 'approved_by');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'user_id');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'user_id');
    }

    public function reviewedQuotations()
    {
        return $this->hasMany(Quotation::class, 'reviewed_by');
    }

    public function approvedQuotations()
    {
        return $this->hasMany(Quotation::class, 'approved_by');
    }

    public function resetPasswordRequests()
    {
        return $this->hasMany(ResetPasswordRequest::class, 'user_id');
    }

    public function resetPasswords()
    {
        return $this->hasMany(ResetPasswordRequest::class, 'reset_by');
    }

    public function returnProducts()
    {
        return $this->hasMany(ReturnProduct::class, 'user_id');
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'user_id');
    }

    public function unusedProducts()
    {
        return $this->hasMany(UnusedProduct::class, 'user_id');
    }

    public function approvedUnusedProducts()
    {
        return $this->hasMany(UnusedProduct::class, 'approved_by');
    }

    public function items()
    {
        return $this->hasMany(ItemUser::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('Super Admin');
    }

    public function isAdmin()
    {
        return $this->hasRole('Admin',);
    }

    public function isVendor()
    {
        return $this->hasRole('Vendor',);
    }

    public function isDirector()
    {
        return $this->hasRole('Director',);
    }

    public function isFinanceDirector()
    {
        return $this->hasRole('Finance Director',);
    }

    public function isStaff()
    {
        return $this->hasRole('Staff',);
    }

    public function isStoreManager()
    {
        return $this->hasRole('Store Manager',);
    }

    public function isStoreKeeper()
    {
        return $this->hasRole('Store Keeper',);
    }

    public function isFinanceStaff()
    {
        return $this->hasRole('Finance Staff',);
    }

    public function isDepartmentHead()
    {
        return $this->hasRole('Department Head',);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'user_id');
    }
}
