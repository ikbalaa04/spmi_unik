@include('element.partials.requirement-form', [
    'pageTitle' => 'Syarat Peringkat Unggul',
    'rankLabel' => 'Peringkat Unggul',
    'headerIcon' => 'fas fa-medal',
    'headerDescription' => 'Tetapkan ambang nilai elemen untuk memenuhi persyaratan peringkat Unggul.',
    'formAction' => url('element/put-unggul/' . $element->id),
    'currentMinimum' => $element->min_unggul,
])
