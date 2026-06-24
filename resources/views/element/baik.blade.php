@include('element.partials.requirement-form', [
    'pageTitle' => 'Syarat Peringkat Baik Sekali',
    'rankLabel' => 'Peringkat Baik Sekali',
    'headerIcon' => 'fas fa-award',
    'headerDescription' => 'Tetapkan ambang nilai elemen untuk memenuhi persyaratan peringkat Baik Sekali.',
    'formAction' => url('element/put-baik/' . $element->id),
    'currentMinimum' => $element->min_baik,
])
