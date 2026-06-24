@include('element.partials.requirement-form', [
    'pageTitle' => 'Syarat Perlu Akreditasi',
    'rankLabel' => 'Akreditasi',
    'headerIcon' => 'fas fa-certificate',
    'headerDescription' => 'Tetapkan ambang dasar agar elemen dinyatakan memenuhi syarat akreditasi.',
    'formAction' => url('element/put-akreditasi/' . $element->id),
    'currentMinimum' => $element->min_akreditasi,
])
