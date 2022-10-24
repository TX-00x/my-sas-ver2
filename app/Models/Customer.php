<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class Customer extends Model implements Auditable
{
    use HasFactory;
    use Notifiable;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'email',
        'description',
        'cs_agent_id',
        'sales_agent_id',
        'logo_id',
    ];

    public function contacts()
    {
        return $this->hasMany(CustomerContact::class);
    }

    /**
     * @deprecated
     */
    public function csAgent()
    {
        return $this->belongsTo(User::class, 'cs_agent_id');
    }

    public function customerSupportAgents(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'customer_sale_agent', 'customer_id', 'user_id');
    }

    /**
     * @deprecated
     */
    public function salesAgent()
    {
        return $this->belongsTo(User::class, 'sales_agent_id');
    }

    public function salesAgents(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'customer_customer_service_agent', 'customer_id', 'user_id');
    }

    public function logo()
    {
        return $this->belongsTo(File::class);
    }

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class, 'customer_id');
    }

    public function scopeWithAll($query)
    {
        return $query->with(['csAgent', 'salesAgent', 'addresses.address.country']);
    }

}
