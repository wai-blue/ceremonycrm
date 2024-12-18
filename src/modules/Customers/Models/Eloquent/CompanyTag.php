<?php

namespace CeremonyCrmMod\Customers\Models\Eloquent;

use CeremonyCrmMod\Settings\Models\Eloquent\Tag;
use CeremonyCrmMod\Settings\Models\Eloquent\User;
use \Illuminate\Database\Eloquent\Relations\HasMany;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CompanyTag extends \ADIOS\Core\Model\Eloquent
{
  public $table = 'company_tags';

  public function TAG(): BelongsTo {
    return $this->belongsTo(Tag::class, 'id_tag', 'id');
  }
  public function COMPANY(): BelongsTo {
    return $this->belongsTo(Company::class, 'id_company', 'id');
  }

}
