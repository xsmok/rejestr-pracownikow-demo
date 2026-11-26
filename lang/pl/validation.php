<?php

/*
|--------------------------------------------------------------------------
| Validation messages (Polish)
|--------------------------------------------------------------------------
|
| Only the rules this application uses. Add a line here when a form starts
| using a new rule, otherwise the user sees the English key.
|
*/

return [

    'before_or_equal' => 'Pole :attribute musi być datą nie późniejszą niż :date.',
    'confirmed' => 'Potwierdzenie pola :attribute nie zgadza się.',
    'date_format' => 'Pole :attribute musi mieć format :format.',
    'email' => 'Pole :attribute musi być prawidłowym adresem e-mail.',
    'enum' => 'Wybrana wartość pola :attribute jest nieprawidłowa.',
    'max' => [
        'numeric' => 'Pole :attribute nie może być większe niż :max.',
        'string' => 'Pole :attribute nie może mieć więcej niż :max znaków.',
    ],
    'min' => [
        'numeric' => 'Pole :attribute musi wynosić co najmniej :min.',
        'string' => 'Pole :attribute musi mieć co najmniej :min znaków.',
    ],
    'multiple_of' => 'Pole :attribute musi być wielokrotnością :value.',
    'numeric' => 'Pole :attribute musi być liczbą.',
    'regex' => 'Format pola :attribute jest nieprawidłowy.',
    'required' => 'Pole :attribute jest wymagane.',
    'string' => 'Pole :attribute musi być tekstem.',
    'unique' => 'Taka wartość pola :attribute już istnieje.',

    /*
    | Messages for a specific field and rule.
    */

    'custom' => [
        'name' => [
            'regex' => 'Imię i nazwisko może zawierać tylko litery, spacje i myślnik.',
        ],
        'password' => [
            'regex' => 'Hasło musi mieć co najmniej 8 znaków, w tym literę i cyfrę.',
        ],
        'month' => [
            'regex' => 'Miesiąc musi mieć format RRRR-MM.',
        ],
        'date' => [
            'date_format' => 'Data musi mieć format RRRR-MM-DD.',
            'unique' => 'Ten dzień jest już wpisany dla tego pracownika.',
            'before_or_equal' => 'Data nie może być z przyszłości.',
        ],
        'hours' => [
            'min' => 'Najmniej można wpisać 0,5 godziny.',
            'max' => 'Najwięcej można wpisać 24 godziny.',
            'multiple_of' => 'Godziny wpisuje się co pół godziny, np. 7,5.',
        ],
    ],

    /*
    | Polish field names used in place of :attribute.
    */

    'attributes' => [
        'name' => 'imię i nazwisko',
        'email' => 'e-mail',
        'password' => 'hasło',
        'role' => 'rola',
        'month' => 'miesiąc',
        'date' => 'data',
        'hours' => 'godziny',
        'content' => 'treść komentarza',
    ],

];
