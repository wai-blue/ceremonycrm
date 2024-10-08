<?php

namespace CeremonyCrmApp\Modules\Core\Billing\Models\Eloquent;

use CeremonyCrmApp\Modules\Core\Customers\Models\Eloquent\Company;

use \Illuminate\Database\Eloquent\Relations\HasMany;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BillingAccount extends \ADIOS\Core\Model\Eloquent
{
  public $table = 'billing_accounts';

  public function id_company(): BelongsTo {
    return $this->belongsTo(Company::class, 'id_company', 'id' );
  }

  public function COMPANY(): BelongsTo {
    return $this->id_company();
  }
  public function SERVICES(): HasMany
  {
    return $this->hasMany(BillingAccountService::class, 'id_billing_account', 'id');
  }
}
