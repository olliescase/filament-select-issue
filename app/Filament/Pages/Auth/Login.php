<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BasePage;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Log;

class Login extends BasePage
{
    public function mount(): void
    {
        parent::mount();

        if (app()->environment('local')) {
            $this->form->fill([
                'email' => 'test@filamentphp.com',
                'password' => 'password',
                'remember' => true,
            ]);
        }
    }

    public function form(Schema $schema): Schema
    {
        $options = [
            'One' => 'One',
            'two' => 'Two',
            'three' => 'Three',
            'four' => 'Four',
            'five' => 'Five',
        ];


        // With the below implementation, you will never see the results for One when searching for "O" because filament
        // makes it lowercase.

        return parent::form($schema)->schema([
            Select::make('test')
                ->searchable()
                ->getSearchResultsUsing(
                    function ($search) use ($options) {
                        Log::debug("Searching for: '{$search}'");

                        return array_filter($options, fn ($label) => str_contains($label, $search));
                    }
                )
        ]);
    }
}
