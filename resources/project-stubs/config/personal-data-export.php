<?php

use Spatie\PersonalDataExport\Mail\PersonalDataExportCreatedMail;

return [

    'disk' => 'personal-data-export',

    'delete_after_days' => 30,

    'authentication_required' => true,

    'mailable' => PersonalDataExportCreatedMail::class,

];
